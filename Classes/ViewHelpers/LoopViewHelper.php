<?php

declare(strict_types=1);

namespace WapplerSystems\Testimonials\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Repeats rendering of children $count times while updating $iteration.
 */
class LoopViewHelper extends AbstractViewHelper
{
    protected $escapeChildren = false;

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('iteration', 'string', 'Variable name to insert result into, suppresses output');
        $this->registerArgument('count', 'integer', 'Number of times to render child content', true);
        $this->registerArgument('minimum', 'integer', 'Minimum number of loops before stopping', false, 0);
        $this->registerArgument('maximum', 'integer', 'Maximum number of loops before stopping', false, PHP_INT_MAX);
    }

    public function render(): string
    {
        $count = max((int)$this->arguments['minimum'], min((int)$this->arguments['count'], (int)$this->arguments['maximum']));
        $iteration = $this->arguments['iteration'];
        $variableProvider = $this->renderingContext->getVariableProvider();

        $hasBackup = $iteration !== null && $variableProvider->exists($iteration);
        $backupVariable = $hasBackup ? $variableProvider->get($iteration) : null;
        if ($hasBackup) {
            $variableProvider->remove($iteration);
        }

        $content = '';
        for ($i = 0; $i < $count; $i++) {
            $content .= $this->renderIteration($i, $count, $iteration);
        }

        if ($hasBackup) {
            $variableProvider->add($iteration, $backupVariable);
        }

        return $content;
    }

    protected function renderIteration(int $i, int $count, ?string $iterationArgument): string
    {
        if (empty($iterationArgument)) {
            return (string)$this->renderChildren();
        }

        $variableProvider = $this->renderingContext->getVariableProvider();
        $cycle = $i + 1;
        $variableProvider->add($iterationArgument, [
            'index' => $i,
            'cycle' => $cycle,
            'isOdd' => $cycle % 2 === 1,
            'isEven' => $cycle % 2 === 0,
            'isFirst' => $i === 0,
            'isLast' => $i + 1 >= $count,
        ]);
        $content = (string)$this->renderChildren();
        $variableProvider->remove($iterationArgument);

        return $content;
    }
}
