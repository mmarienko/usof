<?php

namespace App\Admin\Controllers;

use App\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('Id'));
        $grid->column('author', __('Author'));
        $grid->column('publish_date', __('Publish date'));
        $grid->column('content', __('Content'));
        $grid->column('post_id', __('Post id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('author', __('Author'));
        $show->field('publish_date', __('Publish date'));
        $show->field('content', __('Content'));
        $show->field('post_id', __('Post id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());

        $form->text('author', __('Author'));
        $form->datetime('publish_date', __('Publish date'))->default(date('Y-m-d H:i:s'));
        $form->textarea('content', __('Content'));
        $form->number('post_id', __('Post id'));

        return $form;
    }
}
