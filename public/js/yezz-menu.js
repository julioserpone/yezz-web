

function menuHandle(item){
   
   var thisMenu = document.getElementById('menu-'+item);
   var thisHref = document.getElementById('a-'+item);
   thisMenu.className = 'current';
   thisHref.setAttribute('href', "#"+item);

}


 function showCountriesModal()
  {       
    
    $('#langModal').modal('toggle');

  }


  function openLoginModal()
  {
    $('#modalLogin').modal('toggle');
  }

  function openRegisterModal()
  {
    $('#modalLogin').modal('toggle');
    $('#modalRegister').modal('toggle');
  }


  function openLogoutModal()
  {
    $('#modalLogout').modal('toggle');
  }

  function openReplyModal(ext_id)
  {
    console.log(ext_id);
    
    $('#parent_comment').val(ext_id);
    $('#modalReply').modal('toggle');
  }

