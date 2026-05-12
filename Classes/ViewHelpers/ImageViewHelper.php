<?php

declare(strict_types=1);

namespace WapplerSystems\Testimonials\ViewHelpers;

use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ImageViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'img';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('image', 'object', 'FileReference to render', true);
        $this->registerArgument('alt', 'string', 'Alt text', false, '');
        $this->registerArgument('width', 'string', 'Image width', false);
        $this->registerArgument('height', 'string', 'Image height', false);
        $this->registerArgument('class', 'string', 'CSS class', false);
        $this->registerArgument('cropVariant', 'string', 'Crop variant to use', false, 'default');
    }

    public function render(): string
    {
        $image = $this->arguments['image'];
        $width = $this->arguments['width'];
        $height = $this->arguments['height'];
        $cropVariant = $this->arguments['cropVariant'];

        $imageService = GeneralUtility::makeInstance(ImageService::class);

        try {
            $cropString = $image instanceof \TYPO3\CMS\Core\Resource\FileReference
                ? $image->getProperty('crop')
                : '';
            $cropVariantCollection = CropVariantCollection::create((string)$cropString);
            $cropArea = $cropVariantCollection->getCropArea($cropVariant);

            $processingInstructions = [
                'width' => $width,
                'height' => $height,
                'crop' => $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image),
            ];

            $processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
            $imageUri = $imageService->getImageUri($processedImage);
        } catch (ResourceDoesNotExistException $e) {
            return '';
        }

        $this->tag->addAttribute('src', $imageUri);
        $this->tag->addAttribute('alt', $this->arguments['alt']);
        $this->tag->addAttribute('width', $processedImage->getProperty('width'));
        $this->tag->addAttribute('height', $processedImage->getProperty('height'));

        if ($this->arguments['class']) {
            $this->tag->addAttribute('class', $this->arguments['class']);
        }

        return $this->tag->render();
    }
}
