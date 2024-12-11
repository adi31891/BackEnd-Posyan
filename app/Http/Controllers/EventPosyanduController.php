<?php

    namespace App\Http\Controllers;

    use App\Models\event_posyandu;
    use App\Models\EventPosyandu;
    use Illuminate\Http\Request;

    class EventPosyanduController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $events = event_posyandu::all();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data kegiatan posyandu berhasil diambil'
                ],
                'data' => $events
            ], 200);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            // Dalam konteks REST API, metode ini tidak diperlukan
            return response()->json([
                'meta' => [
                    'code' => 405,
                    'status' => 'error',
                    'message' => 'Method not allowed'
                ],
                'data' => [],
            ], 405);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'event_name' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'start_datetime' => 'required|date',
                'end_datetime' => 'required|date|after:start_datetime',
                // 'foto_event' => 'required|json',
            ]);

            $event = event_posyandu::create($validated);

            if (!$event) {
                return response()->json([
                    'meta' => [
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'Kegiatan Posyandu gagal disimpan'
                    ],
                    'data' => [],
                ], 400);
            }

            return response()->json([
                'meta' => [
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Kegiatan Posyandu berhasil disimpan'
                ],
                'data' => $event,
            ], 201);
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\event_posyandu  
         * @return \Illuminate\Http\Response
         */
        public function show(event_posyandu $eventPosyandu)
        {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Kegiatan Posyandu berhasil ditampilkan'
                ],
                'data' => $eventPosyandu,
            ], 200);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function edit()
        {
            // Dalam konteks REST API, metode ini tidak diperlukan
            return response()->json([
                'meta' => [
                    'code' => 405,
                    'status' => 'error',
                    'message' => 'Method not allowed'
                ],
                'data' => [],
            ], 405);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  
         * @param  \App\Models\event_posyandu  
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, event_posyandu $eventPosyandu)
        {
            $validated = $request->validate([
                'event_name' => 'sometimes|required|string|max:255',
                'lokasi' => 'sometimes|required|string|max:255',
                'start_datetime' => 'sometimes|required|date',
                'end_datetime' => 'sometimes|required|date|after:start_datetime',
                'foto_event' => 'sometimes|required|json',
            ]);

            $eventPosyandu->update($validated);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Kegiatan Posyandu berhasil diupdate'
                ],
                'data' => $eventPosyandu,
            ], 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\event_posyandu
         * @return \Illuminate\Http\Response
         */
        public function destroy(event_posyandu $eventPosyandu)
        {
            $eventPosyandu->delete();
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Kegiatan Posyandu berhasil dihapus'
                ],
                'data' => [],
            ], 200);
        }
    }

