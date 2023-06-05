<form enctype="multipart/form-data" id="form">
	<div class="button-block">
		
		<div class="file-btn">
			<input type="file" name="file" id="file">
		</div>

		<div class="submit-btn">
			<input type="submit" name="file" class="EditPicBtn" value="Change">			
		</div>

	</div>
</form>
<script type="text/javascript">
$(document).ready(function(){

	$("#form").on('submit', function(e){
		e.preventDefault();

		if(!$("#file").val()){
			alert("Please choose a file");
		}

		var formData = new FormData(this);

		$.ajax({
			url: "editPic_in.php",
			type: "POST",
			data: formData,
			cache: false,
			processData: false,
			contentType: false, 

			success:function(data){
			
				$(".image").html(data);

			}
		});

	});

	$("#file").change(function(){
		var file = this.files[0];
		var fileType = file.type;
		var file_size = file.size;
		var match = ['image/jpeg', 'image/jpg', 'image/png'];

		if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))){

			alert("Only JPEG, JPG, PNG, file types are allowed to upload");	
			$("#file").val('');
			return false;
		}

		if(file_size > 5000000){
			alert("sorry file size exceeds");
			$("#file").val('');
			return false; 
		}

	});
});

</script>