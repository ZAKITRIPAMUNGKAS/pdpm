<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\AgendaModel;

class SitemapController extends BaseController
{
    protected $beritaModel;
    protected $agendaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->agendaModel = new AgendaModel();
        helper('cache');
    }

    /**
     * Generate dynamic sitemap.xml
     */
    public function index()
    {
        // Cache sitemap for 24 hours
        $sitemapContent = cache_remember(
            get_cache_key('sitemap_xml'),
            86400, // 24 hours
            function() {
                return $this->generateSitemap();
            }
        );

        return $this->response
                    ->setContentType('application/xml')
                    ->setBody($sitemapContent);
    }

    /**
     * Generate sitemap content
     */
    private function generateSitemap(): string
    {
        $baseUrl = base_url();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            [
                'url' => $baseUrl,
                'changefreq' => 'daily',
                'priority' => '1.0',
                'lastmod' => date('Y-m-d')
            ],
            [
                'url' => $baseUrl . '/profil',
                'changefreq' => 'monthly',
                'priority' => '0.8',
                'lastmod' => date('Y-m-d')
            ],
            [
                'url' => $baseUrl . '/berita',
                'changefreq' => 'daily',
                'priority' => '0.9',
                'lastmod' => date('Y-m-d')
            ],
            [
                'url' => $baseUrl . '/agenda',
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'lastmod' => date('Y-m-d')
            ],
            [
                'url' => $baseUrl . '/galeri',
                'changefreq' => 'weekly',
                'priority' => '0.7',
                'lastmod' => date('Y-m-d')
            ],
            [
                'url' => $baseUrl . '/kontak',
                'changefreq' => 'monthly',
                'priority' => '0.6',
                'lastmod' => date('Y-m-d')
            ]
        ];

        // Add static pages to sitemap
        foreach ($staticPages as $page) {
            $xml .= $this->addUrlToSitemap($page);
        }

        // Add berita pages
        $beritaList = $this->beritaModel->select('slug, updated_at, created_at')->findAll();
        foreach ($beritaList as $berita) {
            $lastmod = $berita['updated_at'] ?? $berita['created_at'];
            $xml .= $this->addUrlToSitemap([
                'url' => $baseUrl . '/berita/' . $berita['slug'],
                'changefreq' => 'monthly',
                'priority' => '0.7',
                'lastmod' => date('Y-m-d', strtotime($lastmod))
            ]);
        }

        // Add agenda pages (if they have public detail pages)
        $agendaList = $this->agendaModel->select('id, updated_at, created_at')
                                      ->where('tanggal_mulai >=', date('Y-m-d', strtotime('-30 days')))
                                      ->findAll();
        foreach ($agendaList as $agenda) {
            $lastmod = $agenda['updated_at'] ?? $agenda['created_at'];
            $xml .= $this->addUrlToSitemap([
                'url' => $baseUrl . '/agenda/' . $agenda['id'],
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => date('Y-m-d', strtotime($lastmod))
            ]);
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Add URL to sitemap XML
     */
    private function addUrlToSitemap(array $urlData): string
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>" . esc($urlData['url']) . "</loc>\n";
        $xml .= "    <lastmod>" . $urlData['lastmod'] . "</lastmod>\n";
        $xml .= "    <changefreq>" . $urlData['changefreq'] . "</changefreq>\n";
        $xml .= "    <priority>" . $urlData['priority'] . "</priority>\n";
        $xml .= "  </url>\n";

        return $xml;
    }

    /**
     * Generate robots.txt
     */
    public function robots()
    {
        $robotsContent = cache_remember(
            'robots_txt',
            86400, // 24 hours
            function() {
                $baseUrl = base_url();
                $content = "User-agent: *\n";
                $content .= "Allow: /\n";
                $content .= "Disallow: /admin/\n";
                $content .= "Disallow: /dashboard/\n";
                $content .= "Disallow: /login\n";
                $content .= "Disallow: /register\n";
                $content .= "Disallow: /writable/\n";
                $content .= "Disallow: /vendor/\n";
                $content .= "\n";
                $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

                return $content;
            }
        );

        return $this->response
                    ->setContentType('text/plain')
                    ->setBody($robotsContent);
    }
}
