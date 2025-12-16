<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'LifeHub'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .feature-icon {
            transition: transform 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: scale(1.05);
        }
        
        input:focus {
            outline: none;
        }
        
        button {
            transition: all 0.2s ease;
        }
        
        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html><?php /**PATH C:\Users\ASUS\Desktop\WebSys_Final_Project\New folder (2)\resources\views/layouts/guest.blade.php ENDPATH**/ ?>