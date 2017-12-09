<?php

/**
 * File: EditAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/27 10:05
 * Description:
 */
class EditAction extends RedAction
{

    public function run()
    {
        $model = new StoreForm();
        if (($post = $this->request->getPost('StoreForm', false)) != false) {
            $model->attributes = $post;
            if ($model->validate() && $model->save()) {
                $this->response(200, '修改成功');
                $this->app->end();
            }
        } elseif (($id = $this->request->getQuery('id', false)) != false) {
            $cargo = Cargo::model()->findByPk($id);
            if (!empty($cargo)) {
                $model->attributes = array(
                    'id' => $cargo->id,
                    'number' => $cargo->number,
                    'name' => $cargo->name,
                    'price' => $cargo->price / 100,
                    'comment' => $cargo->comment,
                );
            }
        }

        $this->render('edit', array(
            'model' => $model
        ));
    }
}