<?php
/**
 * 英文文章标题缩略名，<a target="_blank" href="http://api.codeinto.com/redirect/redirect.php?name=typecho_plugins_Enslug">插件主页</a>
 * 
 * @package Enslug
 * @author happmaoo
 * @version 1.1.3
 * @link http://blog.codeinto.com/
 *
 * 1.1.0 增加编辑文章时单词释义可能出现更新的确认框。
 * 1.1.1 更新百度翻译api，添加api接入输入框。
 * 1.1.2 修复https下无效的问题。
 * 1.1.3 修复未修改标题时失去焦点重复触发翻译弹窗的问题。
 */
class Enslug_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Enslug_Plugin', 'render');
        Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Enslug_Plugin', 'render');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** input form */
        $name1 = new Typecho_Widget_Helper_Form_Element_Text('appid', NULL, '', _t('APP ID'));
        $form->addInput($name1);
        $name2 = new Typecho_Widget_Helper_Form_Element_Text('appkey', NULL, '', _t('密钥 (Key)'),"<p>* 参考的appid:2015063000000001,appkey:12345678,现在使用正常，如果有一天不能用，你可以申请百度翻译api开发平台这样更稳定， 没有的童鞋: (Need a baidu translate api id:) <a href='http://api.fanyi.baidu.com/api/trans/product/desktop?req=developer' target='_blank'>注册(sign in)</a></p>");
        $form->addInput($name2);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
		$appid = Typecho_Widget::widget('Widget_Options')->plugin('Enslug')->appid;
		$appkey = Typecho_Widget::widget('Widget_Options')->plugin('Enslug')->appkey;
	    $script_html = <<<EOF
<script type="text/javascript">
var appid = '$appid';
var key = '$appkey';
var salt = (new Date).getTime();
</script>
<script src="/usr/plugins/Enslug/Enslug.js"></script>
EOF;
echo $script_html;
    }
}
