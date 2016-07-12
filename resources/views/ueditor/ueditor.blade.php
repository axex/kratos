<script src="{!! asset('/ueditor/ueditor.config.js') !!}"></script>
<script src="{!! asset('/ueditor/ueditor.all.min.js') !!}"></script>
{{-- 载入语言文件,根据laravel的语言设置自动载入 --}}
<script src="{!! asset('/ueditor/lang/zh-cn/zh-cn.js') !!}"></script>

<script type="text/javascript">

  var ue = UE.getEditor('ueditor', { //用辅助方法生成的话默认id是ueditor
    pasteplain: false, // 纯文本粘贴
    initialFrameHeight: 300 // 设置默认高度
  }); // 获取纯文本内容

  /* 自定义路由 */
  /*
   var serverUrl=UE.getOrigin()+'/ueditor/test'; //你的自定义上传路由
   var ue = UE.getEditor('ueditor',{'serverUrl':serverUrl}); //如果不使用默认路由，就需要在初始化就设定这个值
   */

  ue.ready(function () {
    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
  });

</script>