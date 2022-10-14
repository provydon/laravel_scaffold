// import CustomJsCss from './components/CustomJsCss'

// Nova.booting(app => {
//   app.component('custom-js-css', CustomJsCss)
// })
setTimeout(() => {
    var els = document.querySelectorAll("a[href='https://nova.laravel.com/licenses']");
    console.log("els: ", els[0]);
    if (els[0]) {
        els[0].style.display = "none";
    }
}, 5000);