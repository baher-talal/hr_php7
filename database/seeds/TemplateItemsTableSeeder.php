<?php

use Illuminate\Database\Seeder;

class TemplateItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('template_items')->delete();
        
        \DB::table('template_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'item' => '<p class="MsoNormal" dir="RTL" style="text-align: right; break-after: avoid;"><b><span lang="AR-SA" style="font-size:
14.0pt">    أنه فى يوم   <span id="signed_date">...</span>  الموافق </span></b><b><span lang="AR-SA" style="font-size:14.0pt;mso-bidi-language:AR-SA;mso-no-proof:no"> <span id="day_name">......</span>  تحرر هذا العقد بين كل من:<o:p></o:p></span></b></p><p class="MsoNormal" dir="RTL" style="mso-pagination:none;page-break-after:avoid;
tab-stops:60.7pt"><b><span lang="AR-SA" style="font-size:14.0pt;"><o:p> </o:p></span></b></p><p class="MsoNormal" dir="RTL" style="text-align: right; margin-right: 40.2pt; text-indent: -20.1pt; line-height: 115%; break-after: avoid;"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;"> أولا: السادة / شركة <span id="first_part_name">....</span>
.<o:p></o:p></span></p><p class="MsoNormal" dir="RTL" style="text-align: right; margin-right: 40.2pt; text-indent: -20.1pt; line-height: 115%; break-after: avoid;"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;"> الكائن مقرها في <span id="first_part_address">...</span>
و لها سجل تجارى رقم ....................... و
بطاقة ضريبية رقم .................، و يمثلها فى هذا العقد السيد
...................... بصفته....................... .</span><span dir="LTR"></span><span dir="LTR"></span><span lang="AR-SA" dir="LTR" style="font-size:14.0pt;line-height:
115%;mso-no-proof:no"><span dir="LTR"></span><span dir="LTR"></span> </span><span lang="AR-EG" style="font-size:14.0pt;line-height:115%;mso-no-proof:no"><o:p></o:p></span></p><p class="MsoNormal" dir="RTL" style="margin-right:40.2pt;text-indent:-20.1pt;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-EG" style="font-size:14.0pt;line-height:115%;"></span><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;"> (ويشار إليه بالطرف
الأول)<o:p></o:p></span></p><p class="MsoNormal" align="right" dir="RTL" style="margin-right: 20.1pt; text-indent: -20.1pt; line-height: 115%; break-after: avoid;"><span lang="AR-SA" style="font-size:14.0pt;line-height:
115%;"><o:p> </o:p></span></p><p class="MsoNormal" dir="RTL" style="text-align: right; margin-right: 40.2pt; text-indent: -20.1pt; line-height: 115%; break-after: avoid;"><span lang="AR-SA" style="font-size:14.0pt;
line-height:115%;">ثانيا: </span><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;"> السادة / شركة <span id="second_part_name">...</span> .</span></p><p class="MsoNormal" dir="RTL" style="text-align: right; margin-right: 40.2pt; text-indent: -20.1pt; line-height: 115%; break-after: avoid;"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;"> الكائن مقرها في  <span id="second_part_address">.....</span> و لها سجل تجارى رقم ....................... و
بطاقة ضريبية رقم .................، و يمثلها فى هذا العقد السيد
...................... بصفته....................... .</span><span dir="LTR"></span><span dir="LTR"></span><span lang="AR-SA" dir="LTR" style="font-size:14.0pt;line-height:
115%;mso-no-proof:no"><span dir="LTR"></span><span dir="LTR"></span> </span><span lang="AR-EG" style="font-size:14.0pt;line-height:115%;"></span></p><p class="MsoNormal" dir="RTL" style="margin-right:40.2pt;text-indent:-20.1pt;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-EG" style="font-size:14.0pt;line-height:115%;mso-no-proof:no"></span><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;"> (ويشار إليه بالطرف الثاني)<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:08:21',
                'updated_at' => '2018-11-15 11:16:39',
            ),
            1 => 
            array (
                'id' => 2,
                'item' => '<div style="margin-right:-1.15pt;text-align: right;">
<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%">
<b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">
تمهيـــــد</span></u></b>
</p>
<p class="MsoNormal" align="right" dir="RTL" style="text-align: right; line-height: 150%;font-size:14.0pt;">
الطرف الأول قدم نفسه على أنه هو حاصل على حقوق استغلال مجموعة من المصنفات الفنية والمدرج بيانها في ملاحق او تفويضات هذا العقد ، بما يمكنه من التعاقد عليها و منح الطرف الثانى حق إتاحتها عبر خدمة الـ  <span id="services"></span>  بشكل حصرى على شبكة   <span id="operators"></span>     
</p>
<p class="MsoNormal" align="right" dir="RTL" style="text-align: right; line-height: 150%;font-size:14.0pt;">
وحيث أن الطرف الثاني يعمل فى مجال تقديم خدمات القيمة المضافة للهاتف المحمول .</p>
<p class="MsoNormal" align="right" dir="RTL" style="text-align: right; line-height: 150%;font-size:14.0pt;">
ولما رغب الطرفان فى التعاون فيما بينهما فقد إتفق وتراضى الطرفان بعد أن أقر كل منهما بأهليته القانونية للتعاقد وخلو إرادته من كافة عيوب الرضا على ما يلى:</p>
<div></div></div>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:10:02',
                'updated_at' => '2018-11-14 16:33:13',
            ),
            2 => 
            array (
                'id' => 3,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الأول<o:p></o:p></span></u></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">يعتبر التمهيد السابق جزء لا يتجزأ من هذا العقد ومتمما له
ولأحكامة ولا يفسر بدونه.<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:12:25',
                'updated_at' => '2018-11-12 10:12:25',
            ),
            3 => 
            array (
                'id' => 4,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الثانى<o:p></o:p></span></u></b></p>

<p class="MsoNormal" dir="RTL" style="font-size:14.0pt;text-align: right; margin-right: 0.25in; line-height: 115%; break-after: avoid;"><br></p><p class="MsoNormal" dir="RTL" style="text-align: right; margin-right: 0.25in; line-height: 115%; break-after: avoid;font-size:14.0pt;">منح الطرف الأول الطرف الثانى بموجب هذا العقد الحق الحصرى في إستغلال والتراخيص باستغلال الأغاني والمصنفات الفنية المتضمنه فى ملاحق هذا العقد وكذا المقاطع الغنائية الخاصة بها وصور المطرب المؤدي لها للاستغلال عبر شبكة  <span id="operators"></span>             ، بحيث يقوم الطرف الثانى بإستغلالها بشكل حصرى على شبكة <span id="operators"></span>                               بإستخدام خدمات التفاعل الصوتى عبر الهاتف ( خدمة رنين المتصل RBT ) لمستخدمى تلك الخدمات وبحيث يتمكن مستخدم الخدمة من إستغلال المصنفات الفنية بكافة أشكالها للاستماع  عبر الـ RBT  خدمة الكول تون .</p><div style="text-align: right;"><br></div>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:12:44',
                'updated_at' => '2018-11-15 10:46:18',
            ),
            4 => 
            array (
                'id' => 5,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الثالث</span></u></b><span lang="AR-SA" style="font-size:14.0pt;line-height:150%;
mso-bidi-language:AR-SA;mso-no-proof:no"><o:p></o:p></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;
line-height:115%;mso-bidi-language:AR-SA;mso-no-proof:no">مقابل الحقوق الممنوحة
من الطرف الأول للطرف الثانى فى البند الثانى أعلاه يقوم الطرف الثاني بإعطاء
الطرف الأول نسبة تعادل        % (          بالمائة) من صافى الدخل ويعتبر صافى
الدخل هو العائدات النقدية المحصلة والمحققة من تقديم الخدمات محل العقد بعد خصم
حصة شركات الاتصالات وأى مصاريف حكومية خاصة بنشاط خدمات القيمة المضافة على أن
تتم المحاسبة بصفة شهريه ، هذا ويتم إحتساب حصة الطرف الأول بناء على التقارير
التى تصدر عن شركات الاتصالات والتى تعتبر نهائية وملزمة للطرفين والتى يحق للطرف
الاول الاطلاع عليها ومراجعتها ، مع التزام الطرف الثانى بإرسال تقارير شهرية من
واقع التقارير المالية الصادره عن شركات الاتصالات خلال 10 ايام من تاريخ استلامها
حتى يتسنى للطرف الاول تقديم فاتورة مطالبة لإستلام حصته من صافى الايرادات .<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:13:14',
                'updated_at' => '2018-11-12 10:13:14',
            ),
            5 => 
            array (
                'id' => 6,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الرابع</span></u></b><span lang="AR-SA" style="font-size:14.0pt;line-height:150%;
mso-bidi-language:AR-SA;mso-no-proof:no"><o:p></o:p></span></p><p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%">

</p><p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">يتعهد الطرف الأول بأنه يمتلك كافة حقوق استغلال المصنفات
المذكورة فى تمهيد هذا العقد بما فيها تحويلها وبثها واستخدامها للتليفون المحمول
وبأنه يمتلك الحق بترخيص تلك الحقوق للطرف الثانى ويتعهد بمسئوليته الكاملة أمام
أى طرف ثالث قد يدعى أى حقوق له على تلك المصنفات بما فيهم المؤلفين والملحنين
بحيث لا يكون الطرف الثاني مسؤولا عن أية قضايا أو منازعات تقام علي الطرف الأول
لأسباب  تتعلق بمنحه للطرف الثانى الحقوق
الواردة بهذا العقد، وبحيث يتحمل الطرف الأول المسئولية كاملة في كل قضايا أو
منازعات تقام علي الطرف الثاني لأسباب تتعلق بمضمون أو محتوى أو ملكية تلك
المصنفات.</span><span dir="LTR" style="font-size:14.0pt;line-height:115%;
mso-bidi-language:AR-SA;mso-no-proof:no"><o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:13:34',
                'updated_at' => '2018-11-12 10:13:34',
            ),
            6 => 
            array (
                'id' => 7,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الخامس</span></u></b><span lang="AR-EG" style="font-size:14.0pt;line-height:150%;
mso-no-proof:no"><o:p></o:p></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">مدة هذا العقد   <span id="peroid"></span> سنه ميلادية وتتجدد تلقائيا ما لم يخطر أحد الطرفين الآخر
برغبته فى عدم التجديد قبل نهايتها بشهر على الأقل.<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:13:50',
                'updated_at' => '2018-11-13 11:36:33',
            ),
            7 => 
            array (
                'id' => 8,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:150%"><b><u><span style="font-size:14.0pt;line-height:150%">البند
السادس</span></u></b><span lang="AR-SA" style="font-size:14.0pt;line-height:150%;"></span></p>

<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u></u></b><b><u><span style="font-size:14.0pt;line-height:150%">سرية المعلومات</span></u></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;">يلتزم كل طرف ويتعهد للطرف الآخر بالمحافظة على سرية جميع
المعلومات التى تصل إليه بصفته طرفاً فى هذا العقد ويتعهد بأن يبذل قصارى جهده لكي
يحافظ هو وموظفيه والأشخاص التابعين له على سرية هذه المعلومات ، ولا يجوز لأي من
طرفي العقد إفشاء أو إستخدام أي من الأسرار التى قد يطلع عليها بموجب هذا العقد
إلا بعد الحصول على الموافقة الكتابية المسبقة للطرف الآخر.</span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:00',
                'updated_at' => '2018-11-12 11:38:33',
            ),
            8 => 
            array (
                'id' => 9,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
السابع ( التنازل عن العقد )</span></u></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">لا يحق للطرفين التنازل أو حوالة هذا العقد أو اي من حقوقه
الواردة فيه أو ملحقاته الي اى طرف آخر الا بعد موافقة الطرف الاخر كتابتة على ذلك
.<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:08',
                'updated_at' => '2018-11-12 15:06:16',
            ),
            9 => 
            array (
                'id' => 10,
                'item' => '<p class="MsoNormal" align="center" dir="RTL" style="text-align:center;line-height:
150%"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:150%">البند
الثامن ( انهاء العقد )<o:p></o:p></span></u></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">1- عند إنتهاء العقد ، يتوقف الطرف الثانى عن إستغلال محتوى
الطرف الاول , وتقديم كشف الحساب الخاص بالخدمة إلى الطرف الاول حتى تاريخ إنتهاء
الخدمة .</span><span dir="LTR" style="font-size:14.0pt;line-height:115%;
mso-bidi-language:AR-SA;mso-no-proof:no"><o:p></o:p></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span dir="RTL"></span><span dir="RTL"></span><span lang="AR-SA" style="font-size:14.0pt;
line-height:115%;mso-bidi-language:AR-SA;mso-no-proof:no"><span dir="RTL"></span><span dir="RTL"></span>2- إتفق الطرفان على أن الحالات التّالية تعتبر من قبيل الظّروف
الإستثنائيّة أو القوة القاهرة التى تبرّر الإنهاء السّابق من قبل الطّرف الآخر:
الإفلاس، خلال الفترات الإستثنائية كالحروب، الكوارث، الأضطرابات ، تعيين قيم أو
مصفى أو حارس قضائى.</span><span dir="LTR" style="font-size:14.0pt;line-height:
115%;mso-bidi-language:AR-SA;mso-no-proof:no"><o:p></o:p></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span dir="RTL"></span><span dir="RTL"></span><span lang="AR-SA" style="font-size:14.0pt;
line-height:115%;mso-bidi-language:AR-SA;mso-no-proof:no"><span dir="RTL"></span><span dir="RTL"></span>3- يحق لأي من الطرفين إنهاء هذا العقد فوراً ودون الحاجة إلى
إنذار أو أعذار أو إتخاذ أي إجراء قانونى أو قضائى آخر فى حالة إخلال أي من
الطرفين بإلتزاماته او تعهداته الواردة فى هذا العقد ، وذلك شريطة إخطار الطرف
المخل بما وقع منه من إخلال والتنبيه عليه</span><span dir="LTR"></span><span dir="LTR"></span><span lang="AR-SA" dir="LTR" style="font-size:14.0pt;line-height:
115%;mso-bidi-language:AR-SA;mso-no-proof:no"><span dir="LTR"></span><span dir="LTR"></span> </span><span lang="AR-SA" style="font-size:14.0pt;line-height:
115%;mso-bidi-language:AR-SA;mso-no-proof:no">بعلاجه خلال 15 يوماً من هذا
الإخطار ومرور تلك المدة دون علاج ما وقع منه من إخلال .<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:16',
                'updated_at' => '2018-11-12 10:14:16',
            ),
            10 => 
            array (
                'id' => 11,
                'item' => '<p class="MsoNormal" dir="RTL" style="text-align: center;line-height: 115%; break-after: avoid;"><b><u><span lang="AR-EG" style="font-size:14.0pt;line-height:115%">البند التاسع ( الأخطارات
والعناوين )</span></u></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:176.05pt;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt 2.75in"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">      </span><span lang="AR-SA" style="font-size:6.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no"><o:p></o:p></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:.25in;text-align:justify;
line-height:115%;mso-pagination:none;page-break-after:avoid;tab-stops:60.7pt"><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no">كافة الاخطارات والمراسلات المتعلقة بهذا العقد تكون صحيحة
ومنتجة لاثارها القانونية إذا ما أرسلت بإنذار رسمي علي يد محضر او بالبريد المسجل
علي العناوين المذكورة اعلاه بالعقد أو أن تسلم إلي الشخص الموجه إليه باليد مقابل
إيصال بالاستلام ، وفي حالة تغيير عنوان المراسلات يلتزم كل طرف بإعلان الطرف
الاخر بعنوان مراسلاته الجديد ، كما اتفق الأطراف على استخدام الرسائل الالكترونية
(</span><span dir="LTR" style="font-size:14.0pt;line-height:115%;mso-bidi-language:
AR-SA;mso-no-proof:no">Emails </span><span dir="RTL"></span><span dir="RTL"></span><span lang="AR-SA" style="font-size:14.0pt;line-height:115%;mso-bidi-language:AR-SA;
mso-no-proof:no"><span dir="RTL"></span><span dir="RTL"></span> ) كوسيلة معتمدة للتخاطب بخصوص الاعمال اليومية
وتفاصيل العمل وتعتبر بمثابة الوثائق الخطية كما تعتبر الرسائل المرسلة من البريد
الالكتروني لأي فريق والمخزنة في نظام الفريق الآخر بمثابة موقعة وموثقة بمجرد إرسالها
دون الحاجة لتوثيقها بأي وسيلة أخرى او توقيعها بتوقيع الكتروني خاص او تخزينها
بشكل خاص.<o:p></o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:23',
                'updated_at' => '2018-11-12 15:07:37',
            ),
            11 => 
            array (
                'id' => 12,
                'item' => '<p class="MsoNormal" dir="RTL" style="margin-right:-1.15pt"><b><u><span lang="AR-EG">البريد
الألكترونى للطرف الأول</span></u><span lang="AR-EG"> :</span></b><span lang="AR-EG">        <span id="first_part_email"> </span></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:64.45pt;text-align:justify"></p>

<p class="MsoNormal" dir="RTL" style="margin-right:64.45pt;text-align:justify"><b></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:-1.15pt;text-align:justify"><b><span lang="AR-EG">الأسم:     ................................                رقم الموبيل: <span id="first_part_phone"></span></span></b></p>

<p class="MsoNormal" dir="RTL" style="margin-right:64.45pt;text-align:justify"></p>

<p class="MsoNormal" dir="RTL" style="margin-right:-1.15pt"><b><u><span lang="AR-EG">البريد
الألكترونى للطرف الثانى</span></u><span lang="AR-EG"> :</span></b><span lang="AR-EG">       <span id="second_part_email"></span></span></p>

<p class="MsoNormal" dir="RTL" style="margin-right:-1.15pt;text-align:justify"><b><span lang="AR-EG">الأسم:     ................................                رقم الموبيل: <span id="second_part_phone"></span></span></b></p>

',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:42',
                'updated_at' => '2018-11-13 11:41:51',
            ),
            12 => 
            array (
                'id' => 13,
                'item' => '<p class="MsoNormal" dir="RTL" style="text-align: center;"><b><span lang="AR-EG" style="font-size:14.0pt">
      <u>البند العاشر<o:p></o:p></u></span></b>
</p>

<p class="MsoNormal" dir="RTL" style="margin-right:-1.15pt"><span lang="AR-SA" style="font-size:14.0pt;mso-bidi-language:AR-SA;mso-no-proof:no">يخضع هذا العقد
لأحكام القوانين ونظام المحاكم المعمول بهما في جمهورية مصر العربية.</span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:14:58',
                'updated_at' => '2018-11-12 15:32:22',
            ),
            13 => 
            array (
                'id' => 14,
                'item' => '<blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><p dir="RTL" style="text-align: center; margin: 0in 82.45pt 2pt 0in;"><b><u><span style="font-size:
14.0pt">البند الحادى عشر</span></u></b></p></blockquote>

<p dir="RTL" style="margin-right:-1.15pt"><span style="font-size:14.0pt;">حرر هذا العقد
من نسختين أصليتين بيد كل طرف نسخة  و
النسخه مكونه من ثلاث ورقات للعمل بها عند الحاجة.<o:p></o:p></span></p>

<p dir="RTL" style="margin-right:-1.15pt"><span lang="AR-SA" style="font-size:14.0pt;"><o:p> </o:p></span></p>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:15:18',
                'updated_at' => '2018-11-12 15:34:07',
            ),
            14 => 
            array (
                'id' => 15,
                'item' => '<table width="100%" dir="rtl">
<tbody>
<tr><td width="50%"><h3><u>الطرف الاول</u></h3></td><td width="50%"><h3><u>الطرف الثاني</u></h3></td></tr>
<tr><td>شركة/ <span id="first_part_name">....</span> </td><td>شركة/ <span id="second_part_name">....</span> </td></tr>
<tr><td>الاسم :</td><td>الاسم :</td></tr>
<tr><td>الصفة :</td><td>الصفة :</td></tr>
<tr><td><p style="line-height:150%;vertical-align:bottom"><br>التوقيع:</p></td><td><p style="line-height:150%;vertical-align:bottom"><br>التوقيع:</p></td></tr>
<tr><td><p style="line-height:250%;vertical-align:bottom"><br>خاتم الشركة : </p></td><td><p style="line-height:250%;vertical-align:bottom"><br>خاتم الشركة : </p></td></tr>
</tbody></table>',
                'template_id' => 1,
                'created_at' => '2018-11-12 10:19:31',
                'updated_at' => '2018-11-13 11:43:02',
            ),
        ));
        
        
    }
}
