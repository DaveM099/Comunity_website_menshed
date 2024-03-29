/*Navigation bar*/

function userScroll() {
  const navbar = document.querySelector('.navbar');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('#2b3041');
      navbar.classList.add('navbar-sticky');
    } else {
      navbar.classList.remove('bg-dark');
      navbar.classList.remove('navbar-sticky');
    }
  });
}

document.addEventListener('DOMContentLoaded', userScroll);

/* Contact form*/
console.log

$(document).ready(function(){
    $('.submit').click(function(event) {
        
        console.log('button clciked')

        var email = $('.email').val()
       
        var statusElm =  $('.status')
        statusElm.empty()

        if(email.length < 5 && email.includes('@') && email.includes('.')){
            event.preventDefault()
            statusElm.append('<div>Email is not valid</div>')
            
        } 
    })

})

/**Gallery**/

$(document).ready(function(){

  $(".filter-button").click(function(){
      var value = $(this).attr('data-filter');
      
      if(value == "all")
      {
          //$('.filter').removeClass('hidden');
          $('.filter').show('1000');
      }
      else
      {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
          $(".filter").not('.'+value).hide('3000');
          $('.filter').filter('.'+value).show('3000');
          
      }
  });
  
  if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});



