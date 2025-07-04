<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Events\FeePaid;
use App\Events\InstallmentPaid;
use App\Models\Student;
use App\Models\classes;
use App\Models\Installment;
use Carbon\Carbon;

class FeeController extends Controller
{


    // ✅ عرض كل الأقساط مع دفعاتها
    public function index()
    {
        return response()->json(Fee::with('installments', 'student')->get());
    }

    // ✅ إضافة دفعة جديدة لطالب
    public function addPayment(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id'   => 'required|exists:classes,id',
            'price'      => 'required|numeric',
            'due_date'   => 'required|date',
        ]);

        $fee = Fee::firstOrCreate(
            [
                'student_id' => $validated['student_id'],
                'class_id'   => $validated['class_id'],
            ],
            [
                'amount'   => $validated['price'] * 2,
                'status'   => 'غير مدفوع',
                'due_date' => $validated['due_date'],
            ]
        );

        $installment = Installment::create([
            'fee_id'   => $fee->id,
            'amount'   => $validated['price'],
            'due_date' => $validated['due_date'],
            'status'   => 'مدفوع',
        ]);

        event(new InstallmentPaid($installment));

        $paidTotal = $fee->installments()->sum('amount');
        if ($paidTotal >= $fee->amount) {
            $fee->update(['status' => 'مدفوع']);
            event(new FeePaid($fee));
        }

        return response()->json(['message' => 'تم دفع الدفعة بنجاح']);
    }
    public function updateInstallment(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'status' => 'nullable|in:مدفوع,غير مدفوع',
        ]);

        $installment = Installment::findOrFail($id);

        $installment->update($validated);

        return response()->json([
            'message' => 'تم تعديل الدفعة بنجاح',
            'installment' => $installment,
        ]);
    }

    // ✅ حذف قسط مع دفعاته
    public function destroy($id)
    {
        $fee = Fee::with('installments')->findOrFail($id);
        $fee->installments()->delete();
        $fee->delete();

        return response()->json([
            'message' => 'تم حذف القسط وكل دفعاته.',
            'fee' => $fee,
        ]);
    }

//      public function index()
//     {
//         return response()->json(Fee::with('installments')->get());
//     }
//      // إنشاء قسط جديد لجميع الطلاب في صف معين
//     public function store(Request $request)
//     {
//         // التحقق من البيانات المدخلة
//         $validated = $request->validate([
//             'class_id' => 'required|exists:classes,id', // التأكد من وجود الصف

//             'due_date' => 'required|date', // تاريخ الاستحقاق
//         ]);

//         // الحصول على الصف بناءً على class_id
//         $class = classes::findOrFail($validated['class_id']); // تأكد من استخدام النامسبايس الصحيح للـ Class

//         // جلب الطلاب الذين ينتمون لهذا الصف
//         $students = Student::where('class_id', $validated['class_id'])->get();

//         // قيمة القسط من الصف
//         $classFee = $class->fees;

//         // إنشاء قسط لكل طالب في الصف
//         foreach ($students as $student) {
//             // إنشاء القسط للطالب
//             $fee = Fee::create([
//                 'student_id' => $student->id,
//                 'type' => $validated['type'],
//                 'amount' => $classFee, // قيمة القسط من الصف
//                 'status' => 'غير مدفوع',
//                 'due_date' => $validated['due_date'],
//             ]);

//             // تقسيم القسط إلى دفعتين
//             $half = $fee->amount / 2;
//             $firstDue = \Carbon\Carbon::parse($fee->due_date);
//             $secondDue = $firstDue->copy()->addMonth();

//             // إنشاء الدفعتين
//             $fee->installments()->createMany([
//                 ['amount' => $half, 'due_date' => $firstDue, 'status' => 'غير مدفوع'],
//                 ['amount' => $half, 'due_date' => $secondDue, 'status' => 'غير مدفوع'],
//             ]);
//         }

//         // إرجاع استجابة تحتوي على التفاصيل
//         return response()->json([
//             'message' => 'تم إنشاء الأقساط لجميع الطلاب في الصف بنجاح.',
//         ], 201);
//     }

//     /**
//      * دفع دفعة واحدة من القسط
//      */
//     public function payInstallment($installmentId)
// {
//     // جلب الدفعة بناءً على id
//     $installment = Installment::findOrFail($installmentId);

//     // التأكد من أن الدفعة لم تدفع مسبقاً
//     if ($installment->status === 'مدفوع') {
//         return response()->json(['message' => 'الدفعة مدفوعة مسبقاً.'], 400);
//     }

//     // تحديث حالة الدفعة إلى مدفوعة
//     $installment->update(['status' => 'مدفوع']);

//     // إشعار عند دفع دفعة واحدة
//     event(new InstallmentPaid($installment));

//     // جلب القسط المرتبط بالدفعة
//     $fee = $installment->fee;

//     // إذا كانت جميع الدفعات مدفوعة، قم بتحديث حالة القسط إلى مدفوع
//     if ($fee->installments()->where('status', 'غير مدفوع')->count() === 0) {
//         $fee->update(['status' => 'مدفوع']);
//         // إشعار عند إكمال دفع القسط
//         event(new FeePaid($fee));
//     }

//     return response()->json(['message' => 'تم دفع الدفعة بنجاح.']);
// }
//     /**
//      * حذف قسط مع دفعاته
//      */
//     public function destroy($id)
//     {
//         // جلب القسط مع الدفعات التابعة له
//         $fee = Fee::with('installments')->findOrFail($id);

//         // حذف الدفعات أولاً ثم القسط
//         $fee->installments()->delete();
//         $fee->delete();

//         return response()->json([
//     'message' => 'تم حذف القسط وكل دفعاته.',
//     'fee' => $fee
//     ]);
//     }
}
