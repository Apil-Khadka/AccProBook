const dashboard = document.getElementById("dashboard");
const company = document.getElementById("company");
const customer = document.getElementById("customer");
const invoice = document.getElementById("invoice");
const product = document.getElementById("product");
const transactions = document.getElementById("transactions");

// company.addEventListener('onclick',()=>{
  //document.querySelectorAll('.nav__link').forEach(l=> l.classList.remove('active'));
  //company.classList.add()
// })

/*===== EXPANDER MENU  =====*/ 
const showMenu = (toggleId, navbarId, bodyId)=>{
    const toggle = document.getElementById(toggleId),
    navbar = document.getElementById(navbarId),
    bodypadding = document.getElementById(bodyId)
    var collapseMenus = document.getElementsByClassName("collapse__menu");
  
  
  
    if(toggle && navbar){
      toggle.addEventListener('click', ()=>{
        navbar.classList.toggle('expander')
  
        bodypadding.classList.toggle('body-pd')
        for (var i = 0; i < collapseMenus.length; i++) {
          collapseMenus[i].classList.remove("showCollapse");
      }
      })
    } 

}
showMenu('nav-toggle','navbar','body-pd')

/*===== LINK ACTIVE  =====*/ 
const linkColor = document.querySelectorAll('.nav__link')
function colorLink(){
  linkColor.forEach(l=> l.classList.remove('active'))
 this.classList.add('active')
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))


// /*===== COLLAPSE MENU  =====*/ 
const linkCollapse = document.getElementsByClassName('collapse__link')
var i

for(i=0;i<linkCollapse.length;i++){
  linkCollapse[i].addEventListener('click', function(){
    const collapseMenu = this.nextElementSibling

    collapseMenu.classList.toggle('showCollapse')

    const rotate = collapseMenu.previousElementSibling
    rotate.classList.toggle('rotate')
  })
}

const divCollapse = document.getElementsByClassName('root__collapse');

for(let j=0;j<divCollapse.length;j++){
  divCollapse[j].addEventListener('click',function(){
    try{
    const expandLinks=divCollapse[j].querySelector(".collapse__menu")
    expandLinks.classList.toggle('showCollapse')
    const collapseIcon = divCollapse[j].querySelector(".collapse__link")
    collapseIcon.classList.toggle('rotate')
    }
    catch(e){
      console.log(j)
    }
  })
}