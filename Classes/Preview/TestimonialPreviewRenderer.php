<?php
namespace WapplerSystems\Testimonials\Preview;

use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Backend\Preview\PreviewRendererInterface;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class TestimonialPreviewRenderer implements PreviewRendererInterface
{
    public function renderPageModulePreviewHeader(GridColumnItem $item): string
    {
        return '<strong>Testimonials Vorschau</strong>';
    }

    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $row = $item->getRecord();
        $output = '<ul style="margin:0; padding-left:20px;">';
        $testimonials = $this->getTestimonials($row['uid'] ?? 0);
        foreach ($testimonials as $testimonial) {
            $title = htmlspecialchars($testimonial['title'] ?? '');
            $content = htmlspecialchars(strip_tags($testimonial['content'] ?? ''));
            if (mb_strlen($content) > 100) {
                $content = mb_substr($content, 0, 100) . '...';
            }
            $output .= '<li>';
            if ($title) {
                $output .= '<strong>' . $title . '</strong><br>';
            }
            $output .= ($content) . '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    public function renderPageModulePreviewFooter(GridColumnItem $item): string
    {
        return '';
    }

    public function wrapPageModulePreview(string $previewHeader, string $previewContent, GridColumnItem $item): string
    {
        return $previewHeader . $previewContent;
    }

    protected function getTestimonials($contentUid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_wstestimonials_domain_model_item');
        $result = $queryBuilder
            ->select('title', 'content')
            ->from('tx_wstestimonials_domain_model_item')
            ->where(
                $queryBuilder->expr()->eq('content_uid', $queryBuilder->createNamedParameter($contentUid, ParameterType::INTEGER))
            )
            ->executeQuery();
        return $result->fetchAllAssociative();
    }
}
