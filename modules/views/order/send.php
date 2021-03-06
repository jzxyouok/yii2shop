<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    $this->title = '发货';
    $this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['/admin/order/list']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<!-- main container -->


    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>发货</h3>
            </div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php
                        if (Yii::$app->session->hasFlash('info')) {
                            echo Yii::$app->session->getFlash('info');
                        }
                        $form = ActiveForm::begin([
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
                            ],
                            'options' => [
                                'class' => 'new_user_form inline-input',
                            ],
                            ]);
                        echo $form->field($model, 'expressno')->textInput(['class' => 'span9']);
                        ?>
                        <div class="span11 field-box actions text-right">
                            <?php echo Html::submitButton('发货', ['class' => 'btn-glow primary']); ?>
                            <span>OR</span>
                            <?php echo Html::resetButton('取消', ['class' => 'reset']); ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- end main container -->



