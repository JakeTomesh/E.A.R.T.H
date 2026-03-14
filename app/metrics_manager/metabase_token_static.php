<?php
require_once __DIR__ . '/../include/bootstrap.php';
require_once __DIR__ . '/../include/auth.php';

header('Content-Type: application/json');

$METABASE_SECRET_KEY = getenv('MB_EMBED_SECRET');
if (!$METABASE_SECRET_KEY) {
    http_response_code(500);
    echo json_encode(['error' => 'Metabase secret not configured']);
    exit();
}
$DASHBOARD_ID = 2; // <-- this is the new dashboard

function base64url_encode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function sign_jwt(array $payload, string $secret): string {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];

    $h = base64url_encode(json_encode($header, JSON_UNESCAPED_SLASHES));
    $p = base64url_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));

    $sig = hash_hmac('sha256', "$h.$p", $secret, true);
    $s = base64url_encode($sig);

    return "$h.$p.$s";
}

try {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Not logged in']);
        exit;
    }

    $licenseeId = (int) $_SESSION['user']->getLicenseeId();
    if ($licenseeId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing licensee id']);
        exit;
    }

    $now = time();

    // IMPORTANT: this key must match what Metabase expects for this dashboard.
    // You previously saw Metabase demand ":licenseeid" (no underscore).
    $lockedParams = [
        'licenseeid' => $licenseeId
    ];

    $payload = [
        'resource' => ['dashboard' => $DASHBOARD_ID],
        'params'   => $lockedParams,
        'iat'      => $now,
        'exp'      => $now + (10 * 60),
    ];

    $token = sign_jwt($payload, $METABASE_SECRET_KEY);
    echo json_encode(['token' => $token], JSON_UNESCAPED_SLASHES);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to generate token'], JSON_UNESCAPED_SLASHES);
}