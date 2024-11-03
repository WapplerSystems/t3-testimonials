<?php
namespace WapplerSystems\Testimonials\ViewHelpers;


use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Repeats rendering of children $count times while updating $iteration.
 */
class LoopViewHelper extends AbstractViewHelper
{

    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;


    public function initializeArguments(): void
    {
        $this->registerArgument('iteration', 'string', 'Variable name to insert result into, suppresses output');
        $this->registerArgument('count', 'integer', 'Number of times to render child content', true);
        $this->registerArgument('minimum', 'integer', 'Minimum number of loops before stopping', false, 0);
        $this->registerArgument('maximum', 'integer', 'Maxiumum number of loops before stopping', false, PHP_INT_MAX);
    }


    /**
     * @return string
     */
    protected static function renderIteration(
        int $i,
        int $from,
        int $to,
        int $step,
        ?string $iterationArgument,
        RenderingContextInterface $renderingContext,
        \Closure $renderChildrenClosure
    ) {
        if (!empty($iterationArgument)) {
            $variableProvider = $renderingContext->getVariableProvider();
            $cycle = (integer) (($i - $from) / $step) + 1;
            $iteration = [
                'index' => $i,
                'cycle' => $cycle,
                'isOdd' => 0 === $cycle % 2,
                'isEven' => 0 === $cycle % 2,
                'isFirst' => $i === $from,
                'isLast' => static::isLast($i, $from, $to, $step)
            ];
            $variableProvider->add($iterationArgument, $iteration);
            $content = $renderChildrenClosure();
            $variableProvider->remove($iterationArgument);
        } else {
            $content = $renderChildrenClosure();
        }

        return $content;
    }


    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        /** @var int $count */
        $count = $arguments['count'];
        /** @var int $minimum */
        $minimum = $arguments['minimum'];
        /** @var int $maximum */
        $maximum = $arguments['maximum'];
        /** @var string|null $iteration */
        $iteration = $arguments['iteration'];
        $content = '';
        $variableProvider = $renderingContext->getVariableProvider();

        if ($count < $minimum) {
            $count = $minimum;
        } elseif ($count > $maximum) {
            $count = $maximum;
        }

        if ($iteration !== null && $variableProvider->exists($iteration)) {
            $backupVariable = $variableProvider->get($iteration);
            $variableProvider->remove($iteration);
        }

        for ($i = 0; $i < $count; $i++) {
            $content .= static::renderIteration(
                $i,
                0,
                $count,
                1,
                $iteration,
                $renderingContext,
                $renderChildrenClosure
            );
        }

        if ($iteration !== null && isset($backupVariable)) {
            $variableProvider->add($iteration, $backupVariable);
        }

        return $content;
    }

    protected static function isLast(int $i, int $from, int $to, int $step): bool
    {
        return ($i + $step >= $to);
    }
}
