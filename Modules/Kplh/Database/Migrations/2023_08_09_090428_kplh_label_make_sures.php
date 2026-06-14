<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('kplh_label', 'maker')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('id', function ($table) {
                    $table->foreignUuid('maker')
                        ->nullable()
                        ->references('id')
                        ->on('users')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'company_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('maker', function ($table) {
                    $table->foreignUuid('company_id')
                        ->nullable()
                        ->references('id')
                        ->on('companies')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'department_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('company_id', function ($table) {
                    $table->foreignUuid('department_id')
                        ->nullable()
                        ->references('id')
                        ->on('departments')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'section_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {

                $table->after('department_id', function ($table) {
                    $table->foreignUuid('section_id')
                        ->nullable()
                        ->references('id')
                        ->on('sections')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'ccow_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('section_id', function ($table) {
                    $table->foreignUuid('ccow_id')
                        ->nullable()
                        ->references('id')
                        ->on('companies')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'pja_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('ccow_id', function ($table) {
                    $table->foreignUuid('pja_id')
                        ->nullable()
                        ->references('id')
                        ->on('employees')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'ktt_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('pja_id', function ($table) {
                    $table->foreignUuid('ktt_id')
                        ->nullable()
                        ->references('id')
                        ->on('companies')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'inspect_id')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('ktt_id', function ($table) {
                    $table->string('inspect_id')->unique();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'inspect_criteria')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('inspect_id', function ($table) {
                    $table->string('inspect_criteria');
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'date')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('inspect_criteria', function ($table) {
                    $table->date('date')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'location')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('date', function ($table) {
                    $table->string('location')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'location_detail')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('location', function ($table) {
                    $table->string('location_detail')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'inspection_officer')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('location_detail', function ($table) {
                    $table->text('inspection_officer')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'target_date')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('inspection_officer', function ($table) {
                    $table->date('target_date')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'settlement_date')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('target_date', function ($table) {
                    $table->date('settlement_date')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'summary')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('settlement_date', function ($table) {
                    $table->text('summary')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_label', 'status')) {
        } else {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->after('summary', function ($table) {
                    $table->string('status')->nullable();
                });
            });
        }

        // Data
        if (Schema::hasColumn('kplh_inspection_data', 'label_id')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('id', function ($table) {
                    $table->foreignUuid('label_id')
                        ->nullable()
                        ->references('id')
                        ->on('kplh_label')
                        ->cascadeOnUpdate()
                        ->nullOnDelete();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'criteria')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('label_id', function ($table) {
                    $table->text('criteria')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'value')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('criteria', function ($table) {
                    $table->integer('value')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'k3_value')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('value', function ($table) {
                    $table->char('k3_value', 50)->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'k3_value_2')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('k3_value', function ($table) {
                    $table->char('k3_value_2', 50)->nullable();
                });
            });

            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('note', function ($table) {
                    $table->timestamps();
                    $table->softDeletes();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'file')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('k3_value_2', function ($table) {
                    $table->text('file')->nullable();
                });
            });
        }

        if (Schema::hasColumn('kplh_inspection_data', 'note')) {
        } else {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('file', function ($table) {
                    $table->text('note')->nullable();
                });
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
