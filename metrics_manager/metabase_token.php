<?php
require_once __DIR__ . '/../include/bootstrap.php';
require_once __DIR__ . '/../include/auth.php';

header('Content-Type: application/json');

$METABASE_SECRET_KEY = getenv('MB_EMBED_SECRET') ?: '919ef03ec76e955dc39c223c1adfd7463754c39c4848039f6a4b119347149f8d';
$DASHBOARD_ID = 3;

// IMPORTANT: params must encode as {} not []
$lockedParams = new stdClass(); // <-- this becomes {} in JSON

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
    $now = time();

    $licenseeId = (int) $_SESSION['user']->getLicenseeId();

    $lockedParams = [
        'licenseeid' => $licenseeId
    ];

    $payload = [
        'resource' => ['dashboard' => $DASHBOARD_ID],
        'params'   => $lockedParams,   // <-- now {}
        'iat'      => $now,
        'exp'      => $now + (10 * 60),
    ];

    $token = sign_jwt($payload, $METABASE_SECRET_KEY);

    echo json_encode(['token' => $token], JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to generate token'], JSON_UNESCAPED_SLASHES);
}