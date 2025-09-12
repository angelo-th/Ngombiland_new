<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        $services = [
            [
                'title' => 'Marketplace Immobilier',
                'description' => 'Trouver ou proposer des biens avec sécurité et outils intelligents.',
                'icon' => 'home',
                'features' => [
                    'Vérification propriétaire',
                    'Géoréférencement précis',
                    'Contact sécurisé',
                ],
            ],
            [
                'title' => 'Crowdfunding Immobilier',
                'description' => 'Investir avec peu de capital via acquisition collective.',
                'icon' => 'users',
                'features' => [
                    'Achat fractionné',
                    'ROI garanti',
                    'Marketplace secondaire',
                ],
            ],
            [
                'title' => 'Technologies Intelligentes',
                'description' => 'Bénéficiez de nos outils IA pour une expérience sécurisée et optimisée.',
                'icon' => 'robot',
                'features' => [
                    'Vérification documentaire',
                    'Estimation automatique',
                    'Chatbot d\'assistance',
                ],
            ],
        ];

        $stats = [
            [
                'value' => '1,250+',
                'label' => 'Biens immobiliers',
            ],
            [
                'value' => '5,8M+',
                'label' => 'FCFA de loyers distribués',
            ],
            [
                'value' => '850+',
                'label' => 'Investisseurs actifs',
            ],
            [
                'value' => '98%',
                'label' => 'Satisfaction clients',
            ],
        ];

        $testimonials = [
            [
                'image' => '/images/user1.jpg',
                'name' => 'Gessy Ken',
                'stars' => 5,
                'half_star' => false,
                'message' => 'Grâce à NGOMBILAND, j\'ai pu investir dans l\'immobilier avec seulement 500 000 FCFA.',
            ],
            [
                'image' => '/images/user2.jpg',
                'name' => 'Sergio Cheubeu',
                'stars' => 5,
                'half_star' => false,
                'message' => 'Le système de vérification des propriétaires m\'a rassuré pour louer mon appartement.',
            ],
            [
                'image' => '/images/user3.jpg',
                'name' => 'Franck Barthel',
                'stars' => 4,
                'half_star' => true,
                'message' => 'La version USSD est géniale pour suivre mes investissements même sans smartphone.',
            ],
        ];

        return view('welcome', compact('services', 'stats', 'testimonials'));
    }

    public function services()
    {
        $services = [
            [
                'title' => 'Marketplace Immobilier',
                'description' => 'Trouver ou proposer des biens avec sécurité et outils intelligents.',
                'icon' => 'home',
                'features' => [
                    'Vérification propriétaire',
                    'Géoréférencement précis',
                    'Contact sécurisé',
                ],
            ],
            [
                'title' => 'Crowdfunding Immobilier',
                'description' => 'Investir avec peu de capital via acquisition collective.',
                'icon' => 'users',
                'features' => [
                    'Achat fractionné',
                    'ROI garanti',
                    'Marketplace secondaire',
                ],
            ],
            [
                'title' => 'Technologies Intelligentes',
                'description' => 'Bénéficiez de nos outils IA pour une expérience sécurisée et optimisée.',
                'icon' => 'robot',
                'features' => [
                    'Vérification documentaire',
                    'Estimation automatique',
                    'Chatbot d\'assistance',
                ],
            ],
        ];

        return view('services', compact('services'));
    }

    public function about()
    {
        $team = [
            [
                'name' => 'Gessy Ken',
                'role' => 'CEO & Fondateur',
                'image' => '/images/team1.jpg',
                'bio' => 'Expert en immobilier avec 10 ans d\'expérience au Cameroun.',
            ],
            [
                'name' => 'Sergio Cheubeu',
                'role' => 'CTO',
                'image' => '/images/team2.jpg',
                'bio' => 'Développeur full-stack spécialisé dans les fintech.',
            ],
            [
                'name' => 'Franck Barthel',
                'role' => 'CFO',
                'image' => '/images/team3.jpg',
                'bio' => 'Expert financier en investissements immobiliers.',
            ],
        ];

        return view('about', compact('team'));
    }

    public function contact()
    {
        return view('contact');
    }
}
