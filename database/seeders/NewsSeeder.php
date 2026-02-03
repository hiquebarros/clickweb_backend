<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsItems = [
            [
                'title' => 'Laravel 12 Lançado com Novas Funcionalidades',
                'content' => 'A equipe do Laravel anunciou o lançamento da versão 12 do framework, trazendo melhorias significativas em performance e novas funcionalidades que facilitam o desenvolvimento de aplicações web modernas.',
                'author' => 'João Silva',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'PHP 8.3 Melhora Performance em 15%',
                'content' => 'A nova versão do PHP traz otimizações importantes no motor de execução, resultando em melhorias de performance de até 15% em aplicações web.',
                'author' => 'Maria Santos',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Tendências de Desenvolvimento Web em 2024',
                'content' => 'Especialistas apontam as principais tendências para desenvolvimento web este ano, incluindo inteligência artificial, serverless architecture e desenvolvimento com componentes reutilizáveis.',
                'author' => 'Pedro Oliveira',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Segurança em Aplicações Web: Boas Práticas',
                'content' => 'Com o aumento de ataques cibernéticos, é essencial seguir boas práticas de segurança ao desenvolver aplicações web. Este artigo apresenta as principais recomendações.',
                'author' => 'Ana Costa',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'API RESTful: Guia Completo para Iniciantes',
                'content' => 'Aprenda a criar APIs RESTful robustas e escaláveis seguindo os princípios REST e utilizando as melhores práticas da indústria.',
                'author' => 'Carlos Mendes',
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($newsItems as $item) {
            News::create($item);
        }
    }
}
