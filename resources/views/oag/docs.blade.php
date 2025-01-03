<html lang="en">
<head>
    <title>{{ config('oag.title) }}</title>
    <link rel="stylesheet"
          href="https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui.css"
    />
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js" crossorigin></script>
<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: {{ $url }},
            dom_id: '#swagger-ui'
        });
    };
</script>
</body>
</html>
