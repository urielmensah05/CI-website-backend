<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Formation;
use App\Models\Equipe;
use App\Models\SiteTexte;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création ou mise à jour du compte administrateur principal
        $admin = User::updateOrCreate(
            ['email' => 'admin@ciwebsite.ci'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('12345'),
            ]
        );

        // 2. Création des Services par défaut
        $services = [
            [
                'name' => "Développement d'applications sur mesure",
                'description' => "Nous concevons des applications web et mobiles rapides, sécurisées et adaptées aux besoins réels du terrain africain.",
                'icon' => "Code2"
            ],
            [
                'name' => "Solutions digitales pour entreprises",
                'description' => "Nous développons des outils et plateformes digitales pour optimiser les processus internes et accélérer la croissance.",
                'icon' => "Settings"
            ],
            [
                'name' => "Accompagnement technologique & innovation",
                'description' => "De l'idée à la mise en production, nous vous aidons à faire les bons choix technologiques et stratégiques.",
                'icon' => "TrendingUp"
            ]
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['name' => $srv['name']], $srv);
        }

        // 3. Création des Formations / Solutions par défaut
        $formations = [
            [
                'titre' => "Développement d'applications multi-plateformes",
                'description' => "Apprenez à concevoir et déployer des applications web et mobiles modernes, utilisées en entreprise.",
                'user_id' => $admin->id
            ],
            [
                'titre' => "Visualisation architecturale 3D",
                'description' => "Maîtrisez la modélisation et le rendu 3D pour des projets architecturaux réalistes et professionnels.",
                'user_id' => $admin->id
            ],
            [
                'titre' => "Formation professionnelle & coaching",
                'description' => "Développez vos compétences techniques et votre posture professionnelle grâce à un accompagnement personnalisé.",
                'user_id' => $admin->id
            ],
            [
                'titre' => "Assistance et intervention logicielle",
                'description' => "Maintenance, dépannage et optimisation de solutions logicielles existantes.",
                'user_id' => $admin->id
            ]
        ];

        foreach ($formations as $form) {
            Formation::updateOrCreate(['titre' => $form['titre']], $form);
        }

        // 4. Création des Membres de l'Équipe par défaut
        $membres = [
            [
                'nom' => "Dr. Elder Akpa A.H.",
                'poste' => "Expert Informatique, Docteur en Informatique au Japon",
                'photo' => "/images/testimonials/5.jpg",
                'user_id' => $admin->id
            ],
            [
                'nom' => "Goh Gedeon",
                'poste' => "Ingenieur Informatique ",
                'photo' => "/images/testimonials/7.jpg",
                'user_id' => $admin->id
            ],
            [
                'nom' => "Hermann Fall",
                'poste' => "Ingénieur Financier",
                'photo' => "/images/testimonials/2.jpg",
                'user_id' => $admin->id
            ]
        ];

        foreach ($membres as $mbr) {
            Equipe::updateOrCreate(['nom' => $mbr['nom']], $mbr);
        }

        // 5. Création des Textes statiques par défaut
        $textes = [
            // Hero
            ['cle' => 'hero_titre', 'valeur' => 'Donner du sens à vos innovations', 'section' => 'hero'],
            ['cle' => 'hero_description', 'valeur' => 'Central Innovation Plus accompagne les entreprises et les talents dans la transformation digitale.', 'section' => 'hero'],
            ['cle' => 'hero_bouton', 'valeur' => 'Découvrir nos services', 'section' => 'hero'],

            // Services
            ['cle' => 'services_titre', 'valeur' => 'Nos services', 'section' => 'services'],
            ['cle' => 'services_description', 'valeur' => 'Chez CENTRAL INNOVATION PLUS, nous comprenons que chaque projet est unique. Que vous recherchiez des solutions digitales innovantes, une logistique efficace, des opportunités immobilières exceptionnelles ou des services de santé de pointe, nous nous engageons à dépasser vos attentes.', 'section' => 'services'],
            ['cle' => 'services_cta', 'valeur' => 'Discutons de votre projet', 'section' => 'services'],

            // Solutions
            ['cle' => 'solutions_titre', 'valeur' => 'Nos solutions', 'section' => 'solutions'],
            ['cle' => 'solutions_description', 'valeur' => "Des formations pratiques pour acquérir les compétences du numérique d'aujourd'hui.", 'section' => 'solutions'],

            // Équipe
            ['cle' => 'equipe_titre', 'valeur' => 'Notre équipe', 'section' => 'equipe'],
            ['cle' => 'equipe_description', 'valeur' => "Nous sommes des jeunes Cadres et Entrepreneurs Ivoiriens, tous diplômés et forts d'expériences professionnelles diverses.", 'section' => 'equipe'],

            // Contact
            ['cle' => 'contact_titre', 'valeur' => 'Nous contacter', 'section' => 'contact'],
            ['cle' => 'contact_description', 'valeur' => 'Une équipe prête à vous répondre dans les plus brefs délais.', 'section' => 'contact'],
            ['cle' => 'contact_adresse', 'valeur' => 'Imm. Riviera palmeraie, face Paris baguette, 2e étage, Cocody', 'section' => 'contact'],
            ['cle' => 'contact_telephones', 'valeur' => "(+225) 27 00 00 00 01\n(+225) 01 01 43 76 78\n(+225) 07 07 48 27 52", 'section' => 'contact'],
            ['cle' => 'contact_emails', 'valeur' => "recrutement@ci-plus.ci\netudes@plus.ci\ninfo@ci-plus.ci", 'section' => 'contact'],

            // Partenaires
            ['cle' => 'partenaires_titre', 'valeur' => 'Nos Partenaires', 'section' => 'partenaires'],
        ];

        foreach ($textes as $txt) {
            SiteTexte::updateOrCreate(['cle' => $txt['cle']], $txt);
        }
    }
}

