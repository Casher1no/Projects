<?php
namespace App\Controller;

use App\View;
use App\Model\Article;
use App\Database;
use App\Redirect;

session_start();

class ArticleController
{
    public function index():View
    {
        $articlesQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->orderBy('created_at', 'desc')
            ->fetchAllAssociative();

        

        $articles = [];

        foreach ($articlesQuery as $article) {
            $articles[] = new Article(
                $article['author'],
                (int)$article['author_id'],
                $article['title'],
                $article['description_text'],
                $article['created_at'],
                $article['id'],
            );
        }
        
        

        return new View("Articles/index", [
            'articles' => $articles,
            'userName' => $_SESSION['name'],
            'userId' => $_SESSION['userid'],
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
            $articlesQuery[0]['author'],
            $articlesQuery[0]['author_id'],
            $articlesQuery[0]['title'],
            $articlesQuery[0]['description_text'],
            $articlesQuery[0]['created_at'],
            $articlesQuery[0]['id']
        );


        return new View("Articles/show", [
            'article' => $article
        ]);
    }
    public function create():View
    {
        return new View('Articles/create');
    }
    public function store():Redirect
    {
        $articlesQuery = Database::connection()
        ->insert('articles', [
            'title' => $_POST['title'],
            'description_text' => $_POST['description'],
            'author' => $_SESSION['name'],
            'author_id' => $_SESSION['userid'],
        ]);

        return new Redirect('/articles');
    }
    public function delete(array $vars):Redirect
    {
        $articlesQuery = Database::connection()
            ->delete('articles', ['id'=>(int)$vars['id']
            ]);

        return new Redirect('/articles');
    }
    public function edit(array $vars):View
    {
        $articlesQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where("id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();
       

        $article = new Article(
            $articlesQuery[0]['author'],
            $articlesQuery[0]['author_id'],
            $articlesQuery[0]['title'],
            $articlesQuery[0]['description_text'],
            $articlesQuery[0]['created_at'],
            $articlesQuery[0]['id']
        );

        return new View("Articles/edit", [
            'article' => $article
        ]);
    }
    public function update(array $vars):Redirect
    {
        Database::connection()->update("articles", [
            'title' => $_POST['title'],
            'description_text' => $_POST['description'],
        ], ['id' => (int)$vars['id']]);

        return new Redirect("/articles");
    }
}
