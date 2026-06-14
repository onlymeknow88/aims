<?php

namespace Modules\Sap\Imports;

use Illuminate\Support\Facades\Auth;
use Modules\Sap\Entities\SapMonthly;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Sap\Entities\SapMonthlyCategory;
use Modules\Sap\Entities\SapDepartmentCodes;

class MonthlyEmployeeImport implements ToModel, WithHeadingRow
{
    public static $errors = [];
    public function model(array $row)
    {
        // Validasi minimal: name dan code wajib
        if (empty($row['name']) || empty($row['code'])) {
            self::$errors[] = 'Baris dengan nama "' . ($row['name'] ?? '-') . '" gagal: Kolom name dan code wajib diisi.';
            return null;
        }

        // Siapkan data kategori (department/category) sesuai $fillable model
        $categoryFillable = [
            'user_id', 'slug', 'name', 'description', 'available', 'code', 'department_id'
        ];
        $inputCategory = [];
        // Gunakan department_name jika ada, jika tidak fallback ke name (untuk kategori)
        $categoryName = isset($row['department_name']) && !empty($row['department_name'])
            ? $row['department_name']
            : $row['name'];
        foreach ($categoryFillable as $field) {
            if ($field === 'name') {
                $inputCategory['name'] = $categoryName;
                $inputCategory['slug'] = \Str::slug($categoryName, '-');
            } elseif (isset($row[$field])) {
                $inputCategory[$field] = $row[$field];
            }
        }
        $inputCategory['user_id'] = Auth::id();
        
        // Ambil department_id dari SapDepartmentCodes berdasarkan code (sesuai Create.php)
        $deptCode = SapDepartmentCodes::where('code', $row['code'])->first();
        if ($deptCode) {
            $inputCategory['department_id'] = $deptCode->department_id;
        }

        try {
            // Update/insert kategori berdasarkan code
            $category = SapMonthlyCategory::updateOrCreate(
                ['code' => $row['code']],
                $inputCategory
            );

            // Logic otomatis assign grade_code berdasarkan grade
            $gradeMapping = [
                'Dept Head' => 'pjo',
                'Foreman, Spv, S/H' => 'pja',
                'Karyawan' => 'maker'
            ];
            
            // Siapkan data pegawai sesuai $fillable model
            $employeeFillable = [
                'user_id', 'category_id', 'slug', 'jde', 'name', 'position', 'dept', 'company_name', 'grade', 'grade_code', 'code', 'id_number', 'department_id'
            ];
            $inputEmployee = [];
            foreach ($employeeFillable as $field) {
                if (isset($row[$field])) {
                    $inputEmployee[$field] = $row[$field];
                }
            }
            
            // Auto assign grade_code berdasarkan grade
            if (isset($row['grade']) && !empty($row['grade'])) {
                $inputEmployee['grade_code'] = $gradeMapping[$row['grade']] ?? null;
            }
            
            $inputEmployee['user_id'] = Auth::id();
            $inputEmployee['category_id'] = $category->id;
            // Ambil department_id dari kategori yang sudah dibuat (sesuai Create.php)
            if (isset($category->department_id)) {
                $inputEmployee['department_id'] = $category->department_id;
            }

            // Pencocokan updateOrCreate: id_number jika ada, jika tidak name+code
            if (!empty($row['id_number'])) {
                $match = ['id_number' => $row['id_number'], 'category_id' => $category->id];
            } else {
                $match = ['name' => $row['name'], 'code' => $row['code'], 'category_id' => $category->id];
            }

            $employee = $category->employeeList()->updateOrCreate(
                $match,
                $inputEmployee
            );
            if (!$employee) {
                self::$errors[] = 'Baris dengan name "' . $row['name'] . '" gagal: Data tidak berhasil disimpan.';
            }
            return $employee;
        } catch (\Exception $e) {
            self::$errors[] = 'Baris dengan name "' . $row['name'] . '" gagal: ' . $e->getMessage();
            return null;
        }
    }
}
