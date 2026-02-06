<?php
// Direct database import script
$host = '127.0.0.1';
$dbname = 'passport_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read the SQL file
    $sql = file_get_contents('database/passport_data.sql');
    
    // Split into statements (simple approach)
    $statements = explode(';', $sql);
    
    $count = 0;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !str_starts_with($statement, '--') && !str_starts_with($statement, '/*')) {
            try {
                $pdo->exec($statement);
                $count++;
            } catch (PDOException $e) {
                // Skip duplicate table errors
                if (strpos($e->getMessage(), 'already exists') === false) {
                    echo "Warning: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo "Imported $count statements successfully!\n";
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}