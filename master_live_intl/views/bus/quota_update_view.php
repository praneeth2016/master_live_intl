<script>
function getservices() {

        var opid = $("#operators").val();

        $.post('getservice', {opid: opid}, function (res) {

            $('#service').html(res);
        });
    }
 function getServiceDetails()
        {
            var opid = $("#operators").val();
			var service=$('#service').val();
            if(service == 0)
            {
                alert("Please Provide Service Number");
                $("#service").focus();
                return false;
            }
            else
            {
            $.post("GetServiceReport",{service:service,opid:opid},function(res){
        // alert(res);
         if(res==0)
        
          $('#tbl').html("<span style='color:red;margin:200px'>No data available on selected service</span>");
          else
          $('#tbl').html(res);  
          });
                     
            }
        }
function showLayout(sernum,travel_id,s)
{
var cnt=$('#hf').val();
$.post("getLayoutForQuota",{sernum:sernum,travel_id:travel_id,s:s},function(res){
//alert(res);   
$('#trr'+s).html(res);
$('#uqi'+s).hide();
$('#uqii'+s).show();
for(var i=1;i<=cnt;i++)
{
$('#trr'+i).hide();
}
$('#trr'+s).show();
});

}
function agentType(s)
{
var id=$('#atype'+s).val();
var opid = $('#operators').val();

$.post("SelectAgentType",{id:id,s:s,opid:opid},function(res){
 if(id==1)
{
$('#uqi'+s).show();
$('#uqa'+s).hide();
$('#uqii'+s).html(res);
$('#uqii'+s).show();
}
else if(id==2)
{
$('#uqa'+s).show();
$('#uqi'+s).hide();
$('#uqii'+s).html(res);
$('#uqii'+s).show();
}
else
{
$('#uqa'+s).hide();
$('#uqi'+s).hide();
$('#uqii'+s).hide();
}
});
}
function  chkk(seatname,s,idd){
 //$('#chkd'+s).show(); 
 if($('#unchkd'+s).is(':visible')){
     alert('Grab and Release cannot perform at a time!');
   $("#"+idd).attr('checked', false);
   return false;
 } else{ 
 
 if($('#chkd'+s).is(':visible')){
   $( "#chkd"+s).show();  
 }else{
   $( "#chkd"+s).show();
 }
  var gg2='';
 var gg=$( "#gb"+s).html();

 // if check box is checked 
 if($("#"+idd).is(":checked")){
  if(gg=='' || gg=='&nbsp;')
     gg2=seatname;
     else
  gg2=gg+","+seatname;
 $( "#gb"+s).html(gg2);

 }else{//check box not chcked
      //alert("dfsf");
     var test=","+seatname;
     if(gg.indexOf(test)!="-1")
         test=","+seatname;
         else
           test=seatname;
             
  var result = gg.replace(test,'');  
  $( "#gb"+s).html(result);  

  
 }
  var ggg=$( "#gb"+s).html();
   if(ggg=='' || ggg=='&nbsp;')
     $( "#chkd"+s).hide();
 $( "#unchkd"+s).hide();
 }
 
}
function  unchkk(seatname,s,idd){
   if($('#chkd'+s).is(':visible')){
   alert('Grab and Release cannot perform at a time!');
   $("#"+idd).attr('checked', true);
   return false;
 } else{ 
 //$('#unchkd'+s).show();
 
 if($('#unchkd'+s).is(':visible')){
   $( "#unchkd"+s).show();  
 }else{
   $( "#unchkd"+s).show();
 }
   var gg2='';
 var gg=$( "#rl"+s).html();
 
 // if check box is checked 
 if($("#"+idd).is(":checked")){
    var test=","+seatname;
     if(gg.indexOf(test)!="-1")
         test=","+seatname;
         else
           test=seatname;
            
  var result = gg.replace(test,'');  
  $( "#rl"+s).html(result);
  
 }else{//check box nt chcked
    if(gg=='' || gg=='&nbsp;')
          
     gg2=seatname;
     
     else
  gg2=gg+","+seatname;
 $( "#rl"+s).html(gg2); 
  
 }
 var ggg=$( "#rl"+s).html();
   if(ggg=='' || ggg=='&nbsp;')
     $( "#unchkd"+s).hide();
 $( "#chkd"+s).hide();
 
}//else
}

function quotaUpdate(sernum,travel_id,s,c)
{

        var seats='';
        if(c==1)//grab
         seats=$( "#gb"+s).html();
        else if(c==2)//release
         seats=$( "#rl"+s).html();
         
var agent_type=$('#atype'+s).val();
var agent_id=$('#ag'+s).val();
var ga=$('#ag'+s).val();

if((agent_type=='' || agent_type==0) && c==1)
{
alert('please select Agent Type!');
return false;
}
if((agent_id=='' || agent_id==0) && c==1)
{
alert('Kindly Select Agent Name and update the quota!');
return false;
}
else
{
var r=confirm("Are sure,you want Update Quota!");
if(r==true)
{
if(c==1)//grab
$('#gbupdt'+s).html('Please wait...');
else if(c==2)
 $('#rlupdt'+s).html('Please wait...');
//alert(arr);
$.post("UpdateAndValidate",{service_num:sernum,seat_names:seats,travel_id:travel_id,agent_type:agent_type,agent_id:agent_id,c:c},function(res){   
if(res==1)//for grabbing
{
alert('Seats are Grabbed successfully!');
$( "#chkd"+s).hide();
$( "#gb"+s).html('');//making span value as null
$('#gbupdt'+s).html('Save Changes');
showLayout(sernum,travel_id,s);
 
}
else if(res==2){ // for release
alert('Seats are Released successfully!');
$( "#unchkd"+s).hide();
$( "#rl"+s).html('');  //making span value as null 
$('#rlupdt'+s).html('Save Changes');
showLayout(sernum,travel_id,s);
}
else
{
alert('There was a problem occured, Kindly contact 040-6613 6613');
}
});
}
else
{
return false;
}
}
}
function viewLayoutQuota(sernum,travel_id,s)
{
$('#trr'+s).show();
$('#trr'+s).html('please wait..');
var cnt=$('#hf').val();
$.post("DisplayLayoutForQuota",{sernum:sernum,travel_id:travel_id},function(res){
$('#trr'+s).html(res);
for(var i=1;i<=cnt;i++)
{
$('#trr'+i).hide();
}
$('#trr'+s).show();
});   
}
</script>

<table width="73%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="40" colspan="4" style="padding-left:10px; border-bottom:#999999 solid 1px"><strong>Quota Updation</strong> </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
				<tr>
					<td height="35" align="center" class="size"><span class="label" style="padding-left:15px">Select Operator :</span></td>
					<td align="center"><?php $op_id = 'id="operators" style="width:150px; font-size:12px" onchange="getservices();"';
                     echo form_dropdown('operators',$operators,"",$op_id);?></td>
					<td height="35" align="center">&nbsp;</td>
				</tr>
				<tr>
					<td height="35" align="center" class="size">Service No / Name <strong>:</strong></td>
					<td width="86" align="center"><select name="service" id="service" class="inputfield" style="width:150px;">
							<option value="0">---Select---</option>
						</select></td>
					<td width="209" height="35" align="center"><input  type="button" class="newsearchbtn" name="search" id="search" value="Submit" onClick="getServiceDetails()" /></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td id="tbl">&nbsp;</td>
	</tr>
	<tr>
		<td id="tbl1">&nbsp;</td>
	</tr>
</table>
<br />
<br />
