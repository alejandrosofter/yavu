<div >
<iframe width="100%" height="315" style='padding-bottom:20px' src="https://www.youtube.com/embed/hmOD7ayA1y8?rel=0&autoplay=1&controls=0&showinfo=0"  frameborder="0" allowfullscreen></iframe>
<button style='float:right;' onclick='noVerInicio()' class='btn btn-danger'><i class="icon-remove  icon-white"></i> NO VOLVER A VER</button>
</div>
<script>
function noVerInicio()
{
	$.get('index.php?r=site/noVerInicio',function(data){
		parent.$.fancybox.close();
	});
}
</script>