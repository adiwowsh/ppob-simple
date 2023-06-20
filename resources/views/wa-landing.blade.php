<!DOCTYPE html>
<html>
<head>
    <title>Indo Pulsa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .whatsapp-button {
            display: block;
            width: 180px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            background-color: #25D366;
            color: #FFF;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 30px;
            margin: 0 auto;
            margin-top: 20px;
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .whatsapp-button {
                width: 160px;
                height: 50px;
                line-height: 50px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<h1>Mulai bergabung dengan INDO PULSA</h1>
<p>Agen pulsa termurah seIndonesia, whatsapp CS sekarang</p>
<a href="https://wa.me/{{ env('CS_WA') }}?text={{ urlencode('Halo kak, saya ingin daftar jadi agen pulsa') }}" target="_blank" class="whatsapp-button">
    Mulai Chat Sekarang
</a>

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '{{ env('FACEBOOK_PIXEL', '') }}');
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1"/>
</noscript>
</body>
</html>
