<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeployController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $secret    = config('services.github.webhook_secret');
        $signature = $request->header('X-Hub-Signature-256');

        if (! $signature || ! $secret) {
            abort(401);
        }

        $expected = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);

        if (! hash_equals($expected, $signature)) {
            Log::warning('Webhook: 簽名錯誤', ['ip' => $request->ip()]);
            abort(403);
        }

        $ref = $request->json('ref', '');

        // 只處理 develop 分支的 push
        if ($ref !== 'refs/heads/develop') {
            return response()->json(['message' => "ignored: {$ref}"]);
        }

        $script  = base_path('../../deploy/deploy.sh');
        $logFile = base_path('../../deploy/deploy.log');

        if (! file_exists($script)) {
            Log::error("Webhook: deploy.sh 找不到：{$script}");
            abort(500);
        }

        // 背景執行，不阻塞 GitHub 的 webhook 連線
        exec("bash {$script} >> {$logFile} 2>&1 &");

        Log::info('Webhook: develop 部署已觸發');

        return response()->json(['message' => 'deploying']);
    }
}
