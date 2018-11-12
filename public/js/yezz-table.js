
var server = "http://yezzworld.app/";

var yezzTable = function(id)
{

   this.selectedId = null;
   
   var _tableId = '#'+id;
   this.table = $(_tableId);


  this.table.on('click','tr',function(e){
        e.preventDefault();
        var row = $(this).children('td');
        this.selectedId = $(row[0]).text();
        console.log(this.selectedId);
  });



  this.getSelectedId = function()
   { 
    //var obj = $(this.table.tbody('td'));
     //console.log(obj);
      //return this.selectedId;

      this.table.find('tbody').find('tr').each(function()
       {
            console.log($(this).attr('class').split(' ')[2]);
            if($(this).attr('class') == 'even selected')
            {
                //console.log($(this));
                /*$(this).find('td').each(function()
                {
                 str += $(this).text();
                  console.log(str);
                });*/

            }
           
    });
     

   }

   this.loadData = function(options)
   {
        this.table.dataTable(options);
   }

}







var setTextValue = function(id,value)
{
  var _id = '#'+id;
  $(_id).val(value);
}

var setCheckboxValue = function(id,value)
{
  var _id = '#'+id;
  if (value = 1)
  {
    $(_id).prop('checked', true);
  }else{
    $(_id).prop('checked', false);
  }
  
}


 var showModal = function(options){
    var modal_id     = "#"+options.id;
    
    if (options.message != null ){
      var _id =  "#"+options.id + "-message";
      $(_id).text(options.message); 
    }
     
    if (options.title != null ){
      var _id =  "#"+options.id + "-title";
      $(_id).text(options.title); 
    }
    
       
    $(modal_id).modal('show');  

}



