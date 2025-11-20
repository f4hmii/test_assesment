<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Favorit</title>
</head>
<body style="background: #0b0d0f; color: #e4e4e7; padding: 20px; font-family: Arial;">
    <h1>Test Favorit System</h1>
    
    <h2>Debug Info:</h2>
    <p>User ID: {{ auth()->id() }}</p>
    <p>User Name: {{ auth()->user()?->name }}</p>
    <p>CSRF Token: <code>{{ csrf_token() }}</code></p>
    
    <h2>Test Button:</h2>
    <button onclick="testToggle(1)">Click Me to Test Toggle</button>
    
    <h2>Console Output:</h2>
    <div id="output" style="background: #1e1e2e; padding: 10px; border-radius: 5px; margin-top: 20px; height: 300px; overflow-y: auto; white-space: pre-wrap; font-family: monospace; font-size: 12px;"></div>
    
    <script>
    function log(msg) {
        const output = document.getElementById('output');
        output.textContent += new Date().toLocaleTimeString() + ' > ' + msg + '\n';
        output.scrollTop = output.scrollHeight;
    }
    
    window.onerror = function(msg, url, line) {
        log('ERROR: ' + msg + ' at ' + url + ':' + line);
    };
    
    function testToggle(productId) {
        log('Starting test toggle for product: ' + productId);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        log('CSRF Token obtained: ' + csrfToken.substring(0, 10) + '...');
        
        const payload = {
            produk_id: productId
        };
        log('Sending payload: ' + JSON.stringify(payload));
        
        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            log('Response status: ' + response.status);
            log('Response headers: ' + JSON.stringify({
                'content-type': response.headers.get('content-type')
            }));
            return response.json();
        })
        .then(data => {
            log('Response data: ' + JSON.stringify(data));
        })
        .catch(error => {
            log('ERROR: ' + error.message);
            log('Stack: ' + error.stack);
        });
    }
    
    log('Page loaded');
    log('Route: {{ route('favorit.toggle') }}');
    </script>
</body>
</html>
