$(document).ready(function() {
   $("#btnAddNewVehicle").click(function(){
      $(this).prop('disabled', true);
      $("#table-vehicle").append("<tr class='add-row'><td></td><td><input id='vehicleReg' class='form-control' type='text' placeholder='Registration'/></td><td><select class='form-control' id='vehicleTypes'><option disabled>Vehicle Type</option></select></td><td><button class='btn btn-xs btn-success add-button' data-object='vehicle' data-spec='[\"vehicleReg\",\"vehicleTypes\"]'><span class='glyphicon glyphicon-plus'></span></button></tr>");

      $.getJSON("/types/json").done(function(json){
	 for(i=0;i<json.length;i++) {
	    $("#vehicleTypes").append("<option value='" + json[i].id + "'>" + json[i].name + "</option>");
	 }
      });
      handlers();
   });

   $("#btnAddNewType").click(function(){
      $(this).prop('disabled', true);
      $("#table-type").append("<tr class='add-row'><td colspan='2'><input id='typeName' class='form-control' type='text' placeholder='Type Name'/></td><td><button class='btn btn-success btn-xs add-button' data-object='type' data-spec='[\"typeName\"]'><span class='glyphicon glyphicon-plus'></span></button></td></tr>");
      handlers();
   });

   $("#btnCopyQs").click(function(){
      $.ajax({
	 url: "/type/copyFrom/" + $("#selectType").val() + "-" + $("#selectType").data("current-type"),
	 headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 },
	 method: "GET"
      }).done(function(){
	 location.reload();
      });
   });

   $("#updateType").click(function(){
      $.ajax({
	 url: "./update/",
	 method: "POST",
	 data: {
	    "typeName": $("#typeName").val()
	 },
	 headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 }
      }).done(function(){
      });
   });

   $(".table-hover tr").click(function() {
      window.location = "/" + $(this).data("object") + "/" + $(this).data("object-id");
   });

   $("#dateRangeFilter").daterangepicker({
      autoUpdateInput: false,
      locale: {
	 cancelLabel: 'Clear'
      }
   });

   $("#dateRangeFilter").on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
   });

   $("#dateRangeFilter").on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
   });


   $("input[name=reg]").mask("AA00 AAA");

   handlers();
});

function handlers() {
   // Delete Button
   $(".delete-button").click(function(){
      var object = $(this).data("object");
      var objectId = $(this).data("object-id");
      $.ajax({
	 url: "/" + object + "/" + objectId,
	 headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 },
	 method: "DELETE"
      }).done(function(){alert("success")});
   });

   // Add Button
   $(".add-button").click(function(){
      var object = $(this).data("object");
      var spec = $(this).data("spec");
      var values = {};
      for(i=0;i<spec.length;i++) {
	 values[spec[i]] = $("#" + spec[i]).val();
      }
      $.ajax({
	 url: "/" + object,
	 headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 },
	 data: values,
	 method: "PUT"
      }).done(function(response){
	 var theTable = $("#table-"+object);
	 var dataToAppend = "<tr>"; 
	 $(".add-row").children().each(function(theCell){
	    dataToAppend += "<td>";
	    if($(this).children()[0] != undefined) {
	       theChild = $(this).children();
	       if(theChild.is("input")) {
		  dataToAppend += theChild.val();
	       } else if (theChild.is("select")) {
		  dataToAppend += theChild.find("option:selected").text();
	       } else {
		  dataToAppend += "";
	       }
	    } else {
	       dataToAppend += "";
	    }
	    dataToAppend += "</td>"; 
	 });
	 theTable.append(dataToAppend + "</tr>");
	 $(".add-row").remove();
      });
   });
}
