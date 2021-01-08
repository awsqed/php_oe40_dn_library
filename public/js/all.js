$("#input-image").change(function(){if(this.files&&this.files[0]){var e=new FileReader;e.onload=function(e){$("#imageHolder").attr("src",e.target.result)},e.readAsDataURL(this.files[0])}});
