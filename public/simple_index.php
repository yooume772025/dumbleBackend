<?php
// Simple index file to test if PHP is working
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Dumble Backend 11 - PHP Test</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 25%, #fcd34d 50%, #f59e0b 75%, #d97706 100%); margin: 0; padding: 20px; min-height: 100vh; display: flex; align-items: center; justify-content: center; }";
echo ".container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); text-align: center; max-width: 600px; }";
echo "h1 { color: #d97706; margin-bottom: 20px; }";
echo ".status { background: #10b981; color: white; padding: 10px 20px; border-radius: 10px; margin: 20px 0; }";
echo ".btn { background: #f59e0b; color: white; padding: 12px 24px; border: none; border-radius: 8px; text-decoration: none; display: inline-block; margin: 10px; font-weight: bold; }";
echo ".btn:hover { background: #d97706; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>🚀 Dumble Backend 11 - PHP Test</h1>";
echo "<div class='status'>✅ PHP is working! Version: " . PHP_VERSION . "</div>";
echo "<p>Current directory: " . getcwd() . "</p>";
echo "<p>Server time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP SAPI: " . php_sapi_name() . "</p>";
echo "<a href='/' class='btn'>🏠 Go to Laravel App</a>";
echo "<a href='/install' class='btn'>⚙️ Installation Wizard</a>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
