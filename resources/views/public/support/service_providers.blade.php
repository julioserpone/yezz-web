<?php 
$chat = true;
$langcountry = "";
if (isset($lang_country))
{
  $langcountry = $lang_country; 
} 
?>

@extends('public.layouts.sec')

@section('htmlheader_title')
Home
@endsection


@section('main-content')
<div class="about-block content" id="support">
 <div class="container-fluid">
   <div class="row">

    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
    <div style='overflow:hidden;height:440px;width:100%;'>
      <div id='gmap_canvas' style='height:440px;width:100%;'></div>

      <style>
        #gmap_canvas img{max-width:none!important;background:none!important}
      </style>
    </div>
    <script type='text/javascript'>
      var directions = {!! $directions !!};

      var map;
      function init_map(){
       var styledMapType = new google.maps.StyledMapType(
        [
        {
          stylers: [
          { hue: '#002733' },
          { saturation: -20 }
          ]
        },{
          featureType: 'road',
          elementType: 'geometry',
          stylers: [
          { lightness: 100 },
          { visibility: 'simplified' }
          ]
        },{
          featureType: 'road',
          elementType: 'labels',
          stylers: [
          { visibility: 'off' }
          ]
        }
        ],
        {name: 'YEZZ World'});




       var marker;
       var bounds = new google.maps.LatLngBounds();
       var myOptions = {
        zoom:10,
        center: new google.maps.LatLng(19.5900246, -34.2393994),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
          mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain','styled_map']
        }
      };
      var map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
                       //marker  = new google.maps.Marker({map: map,position: new google.maps.LatLng(19.5900246, -34.2393994)});

                      //infowindow = new google.maps.InfoWindow({content:'<strong>Title</strong><br>London, United Kingdom<br>'});



                      jQuery.each(directions, function(i, val) {
                        var name = (val.name=="" || val.name==null) ? 'YEZZ Service Center' : val.name;
                        var phone = (val.phone_number=="" || val.phone_number==null) ? '' : 'Phone: '+val.phone_number;
                        var address = (val.address=="" || val.address==null) ? '' : '\n'+ val.address;

                        var spInfo =name+'\n'+'Service Provider in '+val.country+val.address+'\n'+phone;

                        var position = new google.maps.LatLng(val.lat, val.lng);
                        bounds.extend(position);
                        marker = new google.maps.Marker({
                          position: position,
                          map: map,
                          title: spInfo ,
                          icon: '/img/yezz.ico'
                        });


                          //Allow each marker to have an info window    
                          google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                              infoWindow.setContent(spInfo);
                              infoWindow.open(map, marker);
                            }
                          })(marker, i));


                           // Automatically center the map fitting all markers on the screen
                           map.fitBounds(bounds);

                         });
              /*
                      google.maps.event.addListener(marker, 'click', function(){
                                 infowindow.open(map,marker);
                      });
                      infowindow.open(map,marker);
                  
                      */

                      map.mapTypes.set('styled_map', styledMapType);
                      map.setMapTypeId('styled_map');
                    }


                    google.maps.event.addDomListener(window, 'load', init_map);
                  </script>
                </div>
              </div>


              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <h2>{{ trans('message.service_providers') }}</h2>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                   <div class="row">
                    <div class="col-md-4">
                      <h3 style="font-weight: 400;">{{ trans('message.global_headquarters') }}</h3>
                      <span>{{ trans('message.north_america') }}</span><br/>
                      <a href="mailto:csusa@sayyezz.com">csusa@sayyezz.com</a>
                    </div>
                    <div class="col-md-4">
                      <h3 style="font-weight: 400;">{{ trans('message.regional_offices') }}</h3>
                      <span>{{ trans('message.latin_america') }}</span><br/>
                      <a href="mailto:cacusa@sayyezz.com">cacusa@sayyezz.com</a>
                    </div>
                    <div class="col-md-4">
                      <h3 style="font-weight: 400;">{{ trans('message.regional_offices') }}</h3>
                      <span>{{ trans('message.europe_africa_mest') }}</span><br/>
                      <a href="mailto:servicescontact@sayyezz.com">servicescontact@sayyezz.com</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div><br/><br/>

              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-2 col-sm-12 col-xs-12 text-center" style="margin-top: 5px;">
                  <a class="btn btn-default" onclick="showList('all','btn-all',1);" id="btn-all">{{ trans('message.all_regions') }}</a>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12 text-center" style="margin-top: 5px;">
                 <span class="btn btn-primary" onclick="showList('na','btn-america',0);" id="btn-america">{{ trans('message.america') }}
                 </span>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 text-center" style="margin-top: 5px;">
                 <a class="btn btn-primary" onclick="showList('eu','btn-eu',0);" id="btn-eu">{{ trans('message.europe') }}</a>
               </div>
               <div class="col-md-2 col-sm-12 col-xs-12 text-center" style="margin-top: 5px;">
                <a class="btn btn-primary" onclick="showList('am','btn-am',0);" id="btn-am">{{ trans('message.africa_mest') }}</a></div>
                <div class="col-md-2"></div>
              </div>

              <div class="content">
                <style type="text/css">
                  .cel_space{
                    margin-top: 12px;
                  }
                  .custom_h3{
                    color:#DD4632;
                  }
                </style>
                <div class="content pt-0 pb-0" id="countries_list"></div> 

              </div>
              <br/>
            </div>
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8" style="padding-left: 24px;">
              <style type="text/css">
                .decoration: hover{
                    text-decoration-color: #000 !important;
                }
              </style>
                <a href="/support/exchange-repair-extension-programs/programs/en" class="decoration">
                <h3 style="color: #5f6f7e;">Exchange and Repair Extension Programs</h3></a>
              </div>
              <div class="col-md-2"></div>

            </div>
          </div>
        </div>
        <br/>

        <!-- Countries Modal -->
        @include('public.layouts.partials.countries') 
        <!-- END Countries Modal -->
        <script type="text/javascript">
         $(document).ready(function(){
          var showAll;
          showList('all','btn-all',1);

        });

         var spList = document.getElementById("countries_list");
         var row;
         var column = 1;
         var count = 0;
         var index = 0;
         var total;
         var _region = "";
         var na = [];
         var eu = [];
         var am = [];


         jQuery.each(directions, function(i, val) 
         {

          switch(val.region){
           case "na":
           na.push(val);
           break;
           case "eu":
           eu.push(val);
           break;
           case "am":
           am.push(val);
           break;
         }
       });


         function showList(region,id, show)
         {
          var data = null;
          showAll = show;
          switch(region)
          {
           case "na":
           data = na;
           total = data.length;
           build(region,data);
           break;
           case "eu":
           data = eu;
           total = data.length;
           build(region,data);
           break;
           case "am":
           data = am;
           total = data.length;
           build(region,data);
           break;
           case "all":
           writeAll();
           break;
         }

         changeClassName(id);
       }


       function build(region,data)
       {
        column = 1;
        index  = 0;
        row    = document.createElement('div');
        _region="";

        if(showAll==0) {spList.innerHTML = "";}

        jQuery.each(data, function(i, val) 
        {
          index = i+1;
          if(_region!=val.region)
          {
            _region = val.region;
            writeHeader(val.region);
          }
          writeInfo(val, column);
          column=column+1;

        });
      }

      function writeInfo(item,col)
      {
        if(col==1)
        {
         writeEmpty(); 
         col=2;
         column = 2;
       }

       if(col>1 && col<6)
       {
        writeColumn(item);

      }
      if(col==6)
      {
        spList.appendChild(row);
        row = document.createElement('div');
        writeEmpty();
        writeColumn(item);
        column=2;
      }
      if(total==index)
      {
        spList.appendChild(row);
      }

    }

    function writeColumn(item)
    {

      var col = document.createElement('div');
      col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
      var h3 = document.createElement('h3');
      h3.className = "custom_h3";
      h3.innerHTML = item.country;
      col.appendChild(h3);
      var name = (item.name != null && item.name != "") ? item.name : "YEZZ Service Center";
      var line2 = document.createElement('span');
      line2.innerHTML = name;
      col.appendChild(line2);
      if(item.phone_number!=null && item.phone_number!="")
      { 
       var line = document.createElement('span');
       line.innerHTML = "<br/>Phone: "+item.phone_number;
       col.appendChild(line);
     }
     if(item.email!=null && item.email!="")
     { 
       var line = document.createElement('span');
       line.innerHTML = "<br/>Email: <a href='mailto:"+item.email+"'>"+item.email+"</a>";
       col.appendChild(line);
     }
     if(item.attention!=null && item.attention!="")
     { 
       var line = document.createElement('span');
       line.innerHTML = "<br/>Call Center({{trans('message.attention')}}): "+item.attention;
       col.appendChild(line);
     }

     row.appendChild(col);

   }

   function writeEmpty()
   {
    row.className = "row";
    var col = document.createElement('div');
    col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
    //col.innerHTML = "&nbsp;";
    row.appendChild(col);

  }

  function changeClassName(id)
  {
    var element = document.getElementsByClassName("btn-default");
    if(element.length > 0)
    {
      var _id = element[0].id;
      if (_id != id){
       element[0].className="btn btn-primary"
       var current = document.getElementById(id);
       current.className = "btn btn-default";
     }


   }
 }

 function writeHeader(reg)
 {  
  var head = document.createElement('div');
  head.className = "row";
  var col = document.createElement('div');
  col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
  //col.innerHTML = "$nbsp;";
  head.appendChild(col); 

  var _reg = "";
  switch(reg){
    case "na":
    _reg = "{{trans('message.service_center_in')}}&nbsp;{{trans('message.america')}}";
    break;
    case "eu":
    _reg = "{{trans('message.service_center_in')}}&nbsp;{{trans('message.europe')}}";
    break;
    case "am":
    _reg = "{{trans('message.service_center_in')}}&nbsp;{{trans('message.africa_mest')}}";
    break;
  }

  col = document.createElement('div');
  col.className = "col-md-8 col-sm-12 col-xs-12 cel_space";
  col.innerHTML = "<h3>"+_reg+"</h3>";
  head.appendChild(col);

  var col = document.createElement('div');
  col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
  col.innerHTML = "&nbsp;";
  head.appendChild(col);    

  spList.appendChild(head);
}

function writeAll()
{
  spList.innerHTML = "";

  total = na.length;
  build('na',na);

  total = eu.length;
  build('eu',eu);
  
  total = am.length;
  build('am',am);

}


</script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHxOSITGi-xgsyWdlKU6QIVEQx_rSPUzk&callback=init_map">
</script>
@endsection