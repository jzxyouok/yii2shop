<?php 
  namespace app\modules\controllers;

  use yii\web\Controller;
  use Yii;
  class CommonController extends Controller
  {

    public $layout = 'layout1';
    protected $actions = ['*'];
    protected $except = [];
    protected $mustlogin = [];
    /**后台页面登录权限(登录才能访问)
     * @return array
     */
    public function behaviors()
  {
      return [
          'access' => [
              'class' => \yii\filters\AccessControl::className(),
              'user' => 'admin',        // 默认user
              'only' => $this->actions,
              'except' => $this->except,
              'rules' => [
                  [
                      // 未登录禁止访问
                      'allow' => false,
                      'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                      'roles' => ['?'],
                  ],
                  [
                      // 未登录允许访问
                      'allow' => true,
                      'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                      'roles' => ['@'],
                  ],
              ],
          ],
      ];
  }

      /**
       * 获取当前用户要访问控制器名称和方法名称
       * @param \yii\base\Action $action
       * @return bool
       * @throws \yii\web\UnauthorizedHttpException
       */
    public function beforeAction($action)
    {
        // var_dump($action);exit;
        if (!parent::beforeAction($action)) {
            return false;
        }
        // controller名称
        $controller = $action->controller->id;
        // 控制器方法名称
        $actionName = $action->id;
        if (Yii::$app->admin->can($controller. '/*')) {
            return true;
        }
        if (Yii::$app->admin->can($controller. '/'. $actionName)) {
            return true;
        }
        throw new \yii\web\UnauthorizedHttpException('对不起，您没有访问'. $controller. '/'. $actionName. '的权限');
        //return true;        // true就是允许访问  权限管理不存在

    }

      /**
       * 之前用户未登录跳转到登录页面
       */
      public function init()
    {
        // var_dump(Yii::$app->controller);die;        // 获取当前访问控制器（init拿不到是null）
        // 获取当前用户要访问控制器名称和方法名称
        // 和用户拥有权限对比
        /*
      if(Yii::$app->session['admin']['isLogin']!=1){
        return $this->redirect(['/admin/public/login']);
      }
        */
    }

  }




