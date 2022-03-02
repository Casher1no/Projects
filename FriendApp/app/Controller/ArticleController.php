<?php
namespace App\Controller;

use App\View;
use App\Model\Article;
use App\Database;
use App\Redirect;
use App\Exceptions\FormValidationException;
use App\Validation\ArticleFormValidation;
use App\Validation\Errors;
use Error;

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

        $articleLikes = Database::connection()
        ->createQueryBuilder()
        ->select('COUNT(id)')
        ->from('article_likes')
        ->where('article_id = ?')
        ->setParameter(0, (int) $vars['id'])
        ->fetchOne();

        $articleComments = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('article_comments')
            ->where("article_id = ?")
            ->setParameter(0, (int) $vars['id'])
            ->fetchAllAssociative();


        return new View("Articles/show", [
            'article' => $article,
            'articleLikes' => (int)$articleLikes,
            'comments' => $articleComments
        ]);
    }
    public function create():View
    {
        return new View('Articles/create', [
            'errors' => Errors::getAll(),
            'inputs' => $_SESSION['inputs'] ?? []
        ]);
    }
    public function store():Redirect
    {
        try {
            $validator = (new ArticleFormValidation($_POST));
            $validator->passes();
        } catch (FormValidationException $exception) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return new Redirect("/articles/create");
        }
        
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
    public function like(array $vars):Redirect
    {
        $articleId = (int)$vars['id'];
        Database::connection()->insert("article_likes", [
            'article_id' => $articleId,
            'user_id' => $_SESSION['userid']
        ]);
            
        return new Redirect("/articles/{$articleId}");
    }

    public function comment(array $vars):Redirect
    {
        $articleId = (int)$vars['id'];
        Database::connection()->insert("article_comments", [
            'article_id' => $articleId,
            'user_id' => $_SESSION['userid'],
            'comment' => $_POST['comment']
        ]);
        return new Redirect("/articles/{$articleId}");
    }
    public function deleteComment(array $vars):Redirect
    {
        $commentId = (int)$vars['id'];
        $articleId = (int)$vars['article_id'];

        Database::connection()
            ->delete('article_comments', ['id'=>$commentId
            ]);

        return new Redirect("/articles/{$articleId}");
    }
}
