<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=480194903000973&autoLogAppEvents=1" nonce="AaViEngJ"></script>
<script>
    function showmnc2(id_mnu2) {
        if (document.getElementById(id_mnu2).style.visibility == 'visible') {
            document.getElementById(id_mnu2).style.visibility = 'hidden';
        } else {
            document.getElementById(id_mnu2).style.visibility = 'visible';
        }
    }
    function showDrawerMenu() {
        document.querySelector('html').classList.toggle('menu-active');
        showmnc2("nav-horizontal");
    }
    expand = function(itemId) {
        Array.from(document.getElementsByClassName('menu-c2')).forEach((e, i) => {
            if (e.id != itemId) e.style.display = 'none'
        });
        elm = document.getElementById(itemId);
        elm.style.display = elm.style.display == 'block' ? 'none' : 'block'
    }
</script>