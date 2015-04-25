
</div> <!-- container-fluid end-->
		<!--page specific plugin scripts-->

		<!--ace scripts-->

		<script src="/resource/js/ace-elements.min.js"></script>
		<script src="/resource/js/ace.min.js"></script>

        <script src="/resource/js/date-time/bootstrap-datepicker.min.js"></script>
        <script src="/resource/js/date-time/bootstrap-timepicker.min.js"></script>
        <script src="/resource/js/date-time/daterangepicker.min.js"></script>
        <!--script src="/resource/js/bootstrap-validation.js"></script-->
        <script src="/resource/js/jquery.validate.min.js"></script>
        <script src="/resource/js/jquery.validate.message_cn.js"></script>
		<!--inline scripts related to this page-->
	</body>
</html>

<script>

function activeMenu(){
    var url = window.location.pathname;;
    var arr = url.split("/");
    var c = arr[1];
    var m = arr[2];
    var activeItem = 'li_'+c+'_'+m;

    if(document.getElementById(activeItem) != undefined ){
        document.getElementById(activeItem).className = 'active';;
        //$('#'+activeItem).parent().parent().className = 'open';
        $('#'+activeItem).parent().css('display','block');
    }
    $('[data-rel=tooltip]').tooltip();
}
$(function(){ 
    activeMenu();
});
</script>
