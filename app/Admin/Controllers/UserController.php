<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('login', __('Login'));
        $grid->column('password', __('Password'));
        $grid->column('full_name', __('Full name'));
        $grid->column('email', __('Email'));
        $grid->column('profile_picture', __('Profile picture'));
        $grid->column('rating', __('Rating'));
        $grid->column('role', __('Role'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('remember_token', __('Remember token'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('login', __('Login'));
        $show->field('password', __('Password'));
        $show->field('full_name', __('Full name'));
        $show->field('email', __('Email'));
        $show->field('profile_picture', __('Profile picture'));
        $show->field('rating', __('Rating'));
        $show->field('role', __('Role'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());

        $form->text('login', __('Login'));
        $form->password('password', __('Password'));
        $form->text('full_name', __('Full name'));
        $form->email('email', __('Email'));
        $form->text('profile_picture', __('Profile picture'))->default('banan.jpg');
        $form->number('rating', __('Rating'));
        $form->text('role', __('Role'))->default('user');
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
