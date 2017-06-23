$(document).ready(function(){
   $("#submitCheck").click(function() {
      responses = {};
      $(".btn.question").each(function() {
	 responses[$(this).data("response")] = $(this).hasClass("active");
      });
      signOff = $("#signOff").hasClass("active");
      mileage = $("#mileage").val();
      if(isNaN(parseInt(mileage))) {
	 $("#mileageGroup").addClass("has-error");
	 return;
      }
      $.ajax({
	 method: "POST",
	 headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 },
	 data: {
	    "responses": responses,
	    "signOff": signOff,
	    "mileage": mileage
	 }
      }).done(function(){
	 window.location.href = "/mobile/vehicle/" + $("#mileage").data("vehicle-id");
      });
   });
   var a=document.getElementsByTagName("a");
   for(var i=0;i<a.length;i++)
   {
       a[i].onclick=function()
       {
	   window.location=this.getAttribute("href");
	   return false
       }
   }
   
   $(".table-hover tr").click(function() {
      window.location = "/mobile/" + $(this).data("object") + "/" + $(this).data("object-id");
   });
});
