<?php
namespace App\Controller;

use App\View;
use App\Model\Article;
use App\Database;

class ArticleController
{
    public function index():View
    {
        $articlesQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articles = [];

        foreach ($articlesQuery as $article) {
            $articles[] = new Article(
                $article['title'],
                $article['description_text'],
                $article['created_at'],
                $article['id']
            );
        }
        

        return new View("Articles/index", [
            'articles' => $articles
        ]);
    }

    public function show(array $vars):View
    {
        $articlesQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where("id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();

       

        $article = new Article(
            $articlesQuery[0]['title'],
            $articlesQuery[0]['description_text'],
            $articlesQuery[0]['created_at'],
            $articlesQuery[0]['id']
        );


        return new View("Articles/show", [
            'article' => $article
        ]);
    }
}
