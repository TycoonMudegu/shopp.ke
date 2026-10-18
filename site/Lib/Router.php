<?php

namespace ShoppKe\Lib;

class Router
{
    private array $routes = [
        '/' => ['home', 'home', 'Shopp.ke | Your business, beautifully connected.', 'An online home for your products, M-Pesa payments, and a clearer path from order to delivery. Built around independent Kenyan businesses.'],
        '/our-story' => ['our-story', 'story', 'Our Story | Shopp.ke', 'A big belief in small businesses. Discover the thinking behind Shopp.ke.'],
        '/seller-stories' => ['seller-stories', 'stories', 'Seller Stories & Field Notes | Shopp.ke', 'Practical ideas for the people behind the products. Explore our independent seller field notes.'],
        '/delivery' => ['delivery', 'delivery', 'Delivery | Shopp.ke', 'Explore the Shopp.ke delivery approach, coverage, and journey from your shop to your customer.'],
        '/pricing' => ['pricing', 'pricing', 'Plans & Pricing | Shopp.ke', 'Find the right setup for your independent business. Explore Starter and Power Seller plans.'],
        '/join' => ['join', 'join', 'Start Selling | Shopp.ke', 'Tell us about your business and request your Shopp.ke store.'],
        '/reach-out' => ['reach-out', 'contact', 'Contact | Shopp.ke', 'Talk to Shopp.ke about your store, delivery, plans, or partnerships.'],
        '/privacy' => ['privacy', 'privacy', 'Privacy | Shopp.ke', 'How Shopp.ke handles information submitted through this website.'],
        '/terms' => ['terms', 'terms', 'Website Terms | Shopp.ke', 'Terms for using the Shopp.ke website and submitting enquiries.'],
        '/thank-you' => ['thank-you', 'thanks', 'Thank You | Shopp.ke', 'Your request has been received.'],
    ];

    public function dispatch(): void
    {
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'), '/');
        if ($base && ($uri === $base || str_starts_with($uri, $base . '/'))) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . trim($uri, '/');

        if (in_array($uri, ['/join', '/login'], true) && in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD'], true)) {
            header('Location: ' . app_url($uri === '/login' ? '/login' : '/register'), true, 302);
            return;
        }

        if ($uri === '/sitemap.xml' && in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD'], true)) {
            header('Content-Type: application/xml; charset=UTF-8');
            echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $paths = array_diff(array_keys($this->routes), ['/thank-you', '/join']);
            foreach ((new Content())->getAllStories() as $story) {
                $paths[] = '/seller-stories/' . $story['slug'];
            }
            foreach ($paths as $path) {
                echo '<url><loc>' . e(rtrim(config('url'), '/') . $path) . '</loc></url>';
            }
            echo '</urlset>';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!in_array($uri, ['/join', '/reach-out', '/subscribe'], true)) {
                http_response_code(405);
                header('Allow: GET, HEAD');
                $this->render('404', '404', 'Page unavailable | Shopp.ke', 'This page could not be found.');
                return;
            }
            $form = (new Forms())->submit($uri);
            if ($form['success']) {
                $_SESSION['receipt'] = ['kind' => $form['kind'], 'reference' => $form['reference']];
                header('Location: /thank-you', true, 303);
                return;
            }
            $GLOBALS['form'] = $form;
            http_response_code($form['status']);
            if ($uri === '/subscribe') {
                $this->render('newsletter', 'newsletter', 'Stay in the Loop | Shopp.ke', 'Sign up for the Shopp.ke dispatch.');
                return;
            }
        } elseif (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD'], true)) {
            http_response_code(405);
            header('Allow: GET, HEAD, POST');
            return;
        }

        if (preg_match('#^/seller-stories/([a-z0-9-]+)$#D', $uri, $matches)) {
            $story = (new Content())->getStory($matches[1]);
            if ($story) {
                $this->render('seller-story', 'story-detail', $story['title'] . ' | Shopp.ke', $story['description'], ['story' => $story]);
                return;
            }
        }

        if (isset($this->routes[$uri])) {
            [$page, $pageId, $title, $description] = $this->routes[$uri];
            $this->render($page, $pageId, $title, $description, ['canonicalPath' => $uri]);
            return;
        }
        http_response_code(404);
        $this->render('404', '404', 'Page Not Found | Shopp.ke', 'Let us help you find your way back.');
    }

    private function render(string $page, string $pageId, string $title, string $description, array $params = []): void
    {
        extract($params, EXTR_SKIP);
        $canonicalPath ??= parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        require __DIR__ . '/../partials/head.php';
        require __DIR__ . '/../partials/nav.php';
        echo '<main id="main">';
        require __DIR__ . '/../pages/' . $page . '.php';
        echo '</main>';
        require __DIR__ . '/../partials/footer.php';
    }
}
