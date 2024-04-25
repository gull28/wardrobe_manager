<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clothing', function (Blueprint $table) {
            $table->integer('uses_left')->default(0);
        });

        $validator = Validator::make(
            ['uses_left' => 0, 'wear_count' => 0],
            ['uses_left' => 'required|integer|min:0', 'wear_count' => 'required|integer|min:0'],
            ['uses_left.min' => 'The uses_left value cannot be negative.', 'wear_count.min' => 'The wear_count value cannot be negative.'],
        );

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        Schema::table('clothing', function (Blueprint $table) {
            $table->integer('uses_left')->default(0)->change();
        });

        DB::statement('ALTER TABLE clothing ADD CONSTRAINT uses_left_check CHECK (uses_left <= wear_count)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clothing', function (Blueprint $table) {
            $table->dropColumn('uses_left');
        });
    }
};
