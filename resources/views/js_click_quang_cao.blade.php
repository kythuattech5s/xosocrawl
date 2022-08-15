@php
    $listClickLinkAds = \App\Models\ClickLinkAds::act()->get();
@endphp
@if (count($listClickLinkAds))
    <script>
        document.body.addEventListener('pointerdown', (event) => {
            var itemLinks = ['{!!implode($listClickLinkAds->pluck('link')->toArray(),"','")!!}'];
            if (event.pointerType === "mouse" || event.pointerType === "touch" || event.pointerType === "pen") {
                var userActionCount = sessionStorage.getItem("user_action_count");
                if (!userActionCount) {
                    userActionCount = 0;
                }
                userActionCount = parseInt(userActionCount);
                if (isNaN(userActionCount) || userActionCount < 0) {
                    userActionCount = 0;
                }
                userActionCount++; 
                sessionStorage.setItem("user_action_count",userActionCount);
                if (userActionCount == {[number_clicks_open_ad_link]}) {
                    sessionStorage.setItem("user_action_count",0);
                    var itemUrl = itemLinks[Math.floor(Math.random()*itemLinks.length)];
                    window.open(itemUrl,'_blank');
                    window.open(itemUrl);
                }
            }
        });
    </script>
@endif