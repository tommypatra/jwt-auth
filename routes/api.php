    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Middleware\Authenticate;
    use App\Models\User;

    Route::post('/login', function (Request $request) {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'data'    => null,
                'message'   => "login gagal"
            ], 401);
        }

        $data = [
            'user' => auth()->guard('api')->user(),
            'token' => $token,
        ];

        return response()->json([
            'status' => true,
            'data'    => $data,
            'message'   => "login berhasil"
        ], 200);
    });

    Route::get('/umum', function (Request $request) {
        $data = User::orderBy('name', 'asc')->get();
        $dataRespon = [
            'status' => true,
            'message' => 'Pengambilan data dilakukan tanpa token',
            'data' => $data,
        ];
        return response()->json($dataRespon);
    });


    //daftarkan midleware auth.token-jwt
    Route::middlewareGroup('auth.token-jwt', [
        Authenticate::class,
    ]);

    //validasi dulu ke auth.token-jwt
    Route::middleware('auth.token-jwt')->group(function () {

        Route::get('/cek-token', function () {
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'message' => 'Token valid',
                'data' => $user,
            ], 200);
        });

        Route::get('/akun', function (Request $request) {
            $data = User::orderBy('name', 'asc')->get();
            $dataRespon = [
                'status' => true,
                'message' => 'Pengambilan data dilakukan',
                'data' => $data,
            ];
            return response()->json($dataRespon);
        });

        Route::post('/logout', function (Request $request) {
            $token = auth()->guard('api')->getToken();
            auth()->guard('api')->logout();

            JWTAuth::invalidate($token);
            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil',
                'data' => null,
            ], 200);
        });
    });


    // Route::fallback(function () {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Route not found',
    //         'data' => null,
    //     ], 404);
    // });
