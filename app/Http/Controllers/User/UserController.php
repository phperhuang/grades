<?php

namespace App\Http\Controllers\User;

use App\ClassInfo;
use App\Subject;
use App\TestDescribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\Common\Autoloader;
use PhpOffice\PhpSpreadsheet\IOFactory;

// 新引入
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

//use phpword;

class UserController extends Controller
{

    public function home()
    {
        return view('user/index/index');
    }

    public function obj2arr($data)
    {
        $data = json_decode(json_encode($data, JSON_UNESCAPED_UNICODE), true);
        return $data;
    }

    public function enteringGrades()
    {
        $class_nos = ClassInfo::orderBy('class_no')->get();
        $tests = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'id']);
        if(count($tests) == 0){
            $tests = [];
        }
        if(count($class_nos) == 0){
            $class_nos = [];
        }
        return view('user/index/entering_grades', ['tests' => $tests, 'class_nos' => $class_nos, 'data' => 23]);
    }

    //
    public function showGrades(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $testData = Subject::where('describe_id', $request->input('describe_id'))->orderBy('class')->get();
            if(count($testData) == 0){
                $testData = [];
            }
            return $testData;
        }else{
            $tests = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'id']);
            if(count($tests) == 0){
                $tests = [];
            }
        }
        return view('user/index/show_grades', ['tests' => $tests]);
    }

    public function enterGradesResult(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $all = $request->except('_token');
            try{
                $grades_result = Subject::create(['class' => $all['class_no'], 'chinese' => $all['chinese'], 'math' => $all['math'],
                    'english' => $all['english'], 'political' => $all['political'], 'history' => $all['history'], 'biology' => $all['biology'],
                    'describe_id' => $all['describe'], 'geography' => $all['geography']]);
                return redirect(url('user/show_grades'));
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }

    }

    // 班级列表信息
    public function classList()
    {
        $data = ClassInfo::orderBy('class_no')->get();
        return view('user/index/show_class_info', ['data' => $data]);
    }

    // 加入班级
    public function addClassInfo()
    {
        return view('user/index/add_class');
    }

    // 处理加入班级
    public function addClassInfoResult(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $all = $request->except('_token');
            try{
                $class_info = ClassInfo::create(['class_no' => $all['class_no'], 'manager' => $all['manager']]);
                return view('user/index/add_class', ['message' => '成功添加班级信息', 'code' => 0]);
            }catch (\Exception $e){
                return ['message' => 'error'];
            }

        }
    }

    /*
     * 考试描述列表
     * */
    public function testDescribeList(TestDescribe $testDescribe)
    {
        $data = TestDescribe::orderBy('test_date', 'desc')->get(['describe', 'test_date']);
        if(count($data) == 0){
            $data = [];
        }
        return view('user/index/test_describe_list', ['data' => $data]);
    }

    // 添加考试描述
    public function addTestDescribe()
    {
        return view('user/index/add_describe');
    }

    /*
     * 处理添加考试描述
     * */
    public function addTestDescribeResult(Request $request)
    {
        $data = $request->except('_token');
        try{
            TestDescribe::create(['describe' => $data['describe'], 'test_date' => $data['test_date']]);
            return redirect(url('user/test_describe_list'));
//            return json_encode(['message' => 'success'], JSON_UNESCAPED_UNICODE);
        }catch (\Exception $e){
            return json_encode(['message' => 'error'], JSON_UNESCAPED_UNICODE);
        }
    }

    // 导入excel 文件，直接生成班级信息
    public function uploadExcelClass(Request $request, $options = [])
    {
        $excelFile = $request->file('upload_file');
        $objRead = IOFactory::createReader('Xlsx');

        if(!$objRead->canRead($excelFile)){
            $objRead = IOFactory::createReader('Xls');
            if(!$objRead->canRead($excelFile)){
                return "只支持导入.xlsx 和 .xls 格式的 excel 文件";
            }
        }

        $objRead->setReadDataOnly(true);
        $excel = $objRead->load($excelFile);
        $currSheet = $excel->getSheet(0);

        $columnCnt = 0;
        if (0 == $columnCnt) {
            /* 取得最大的列号 */
            $columnH = $currSheet->getHighestColumn();
            /* 兼容原逻辑，循环时使用的是小于等于 */
            $columnCnt = Coordinate::columnIndexFromString($columnH);
        }

        $rowCnt = $currSheet->getHighestRow();
        $data   = [];
        /* 读取内容 */
        for ($_row = 1; $_row <= $rowCnt; $_row++) {
            $isNull = true;

            for ($_column = 1; $_column <= $columnCnt; $_column++) {
                $cellName = Coordinate::stringFromColumnIndex($_column);
                $cellId   = $cellName . $_row;
                $cell     = $currSheet->getCell($cellId);

                if (isset($options['format'])) {
                    /* 获取格式 */
                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
                    /* 记录格式 */
                    $options['format'][$_row][$cellName] = $format;
                }

                if (isset($options['formula'])) {
                    /* 获取公式，公式均为=号开头数据 */
                    $formula = $currSheet->getCell($cellId)->getValue();

                    if (0 === strpos($formula, '=')) {
                        $options['formula'][$cellName . $_row] = $formula;
                    }
                }

                if (isset($format) && 'm/d/yyyy' == $format) {
                    /* 日期格式翻转处理 */
                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
                }

                $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());

                if (!empty($data[$_row][$cellName])) {
                    $isNull = false;
                }
            }

            /* 判断是否整行数据为空，是的话删除该行数据 */
            if ($isNull) {
                unset($data[$_row]);
            }
        }

        // 1、先将考试描述存入到数据库，并获取到其 id ;
        $describe = ['describe' => $data[1]['A'], 'test_date' => $data[1]['B'],
            'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")];
        $id = DB::table('test_describes')->insertGetId($describe);

//        print_r($describe);
//        $id = 10;
        // 2、将每个班的成绩，依次录入数据库;
        $newData = [];
        for ($i = 3;$i <= count($data); $i++){
            $gradesData = [
//                'class' => $data[$i]['C'],
//                'chinese' => $data[$i]['D'],
//                'math' => $data[$i]['E'],
//                'english' => $data[$i]['F'],
//                'chemical' => $data[$i]['G'],
//                'political' => $data[$i]['H'],
//                'history' => $data[$i]['I'],
//                'geography' => $data[$i]['J'],
//                'biology' => $data[$i]['K'],
//                'physical' => $data[$i]['L'],
                'class' => $data[$i]['A'],
                'chinese' => $data[$i]['B'],
                'math' => $data[$i]['C'],
                'english' => $data[$i]['D'],
                'chemical' => $data[$i]['E'],
                'political' => $data[$i]['F'],
                'history' => $data[$i]['G'],
                'geography' => $data[$i]['H'],
                'biology' => $data[$i]['I'],
                'physical' => $data[$i]['J'],
                'describe_id' => $id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            DB::table('subjects')->insertGetId($gradesData);
        }
        return redirect(url("user/show_grades"));
    }

    /*
     * 生成周测题目
     * */
    public function testIndex()
    {
        return view('user/week_test/test_index');
    }


    public function exportWords()
    {
        $phpword = new \PhpOffice\PhpWord\PhpWord();
        $phpword->setDefaultFontName('仿宋');
        $phpword->setDefaultFontSize(16);

        // 添加页面
        $section = $phpword->createSection();

        //添加目录
        $styleTOC  = ['tabLeader' => \PHPWord_Style_TOC::TABLEADER_DOT];
        $styleFont = ['spaceAfter' => 60, 'name' => 'Tahoma', 'size' => 12];
        $section->addTOC($styleFont, $styleTOC);

        //默认样式
        $section->addText(iconv('utf-8', 'gbk//IGNORE', 'aaaa第一行文字第一行文字第一行文字第一行文字aaaa'));
        $section->addTextBreak();//换行符

        //指定的样式
        $section->addText(
            'Hello world! 第二行文字第二行文字第二行文字.',
            [
                'name' => '宋体',
                'size' => 16,
                'bold' => true,
            ]
        );
        $section->addTextBreak(5);//多个换行符

        //自定义样式
        $myStyle = 'myStyle';
        $phpword->addFontStyle(
            $myStyle,
            [
                'name' => 'Verdana',
                'size' => 12,
                'color' => '1BFF32',
                'bold' => true,
                'spaceAfter' => 500,
            ]
        );
        $section->addText('第三行文字第三行文字', $myStyle);
        $section->addText('第四行文字', $myStyle);
        $section->addPageBreak();//分页符

        //添加文本资源
//        $textrun = $section->createTextRun();
//        $textrun->addText('I am bold', ['bold' => true]);
//        $textrun->addText('I am italic', ['italic' => true]);
//        $textrun->addText('I am colored', ['color' => 'AACC00']);

        //列表
        $listStyle = ['listType' => \PHPWord_Style_ListItem::TYPE_NUMBER];
        $section->addListItem('河北省', 0, null, $listStyle);
        $section->addListItem('石家庄', 1, null, $listStyle);
        $section->addListItem('邯郸', 1, null, $listStyle);
        $section->addListItem('魏县', 2, null, $listStyle);
        $section->addListItem('河南省', 0, null, $listStyle);
        $section->addListItem('郑州', 1, null, $listStyle);
        $section->addListItem('信阳', 1, null, $listStyle);

        //超级链接
        $linkStyle = ['color' => '0000FF', 'underline' => \PHPWord_Style_Font::UNDERLINE_SINGLE];
        $phpword->addLinkStyle('mylinkStyle', $linkStyle);
        $section->addLink('http://www.baidu.com', '百度', 'mylinkStyle');
        $section->addLink('http://www.lanrenkaifa.com', null, 'mylinkStyle');

        //添加图片
//        $imageStyle = ['width' => 350, 'height' => 350, 'align' => 'center'];
//        $section->addImage(public_path().'/fen.png', $imageStyle);
//        $section->addImage(public_path().'/test.jpg');
        //$section->addMemoryImage('http://localhost/image.php');//添加GD生成图片

        //添加对象，支持后缀：'xls', 'doc', 'ppt'
        //$section->addObject(public_path().'/demo.xls',['align' => 'center']);

        //添加标题,支持1-9标题
        $phpword->addTitleStyle(1, ['bold' => true, 'color' => '1BFF32', 'size' => 38, 'name' => 'Verdana']);
        $section->addTitle('我是标题', 1);
        $section->addTitle('我是标题2', 1);
        $section->addTitle('我是标题3', 1);

        //添加表格
        $styleTable = [
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 50,
        ];
        $styleFirstRow = ['bgColor' => '66BBFF'];//第一行样式
        $phpword->addTableStyle('myTable', $styleTable, $styleFirstRow);

        $table = $section->addTable('myTable');
        $table->addRow(400);//行高400
        $table->addCell(2000)->addText('名称');
        $table->addCell(2000)->addText('价格');
        $table->addCell(2000)->addText('数量');
        $table->addRow(400);//行高400
        $table->addCell(2000)->addText('小米手机');
        $table->addCell(2000)->addText('3999元');
        $table->addCell(2000)->addText('50');
        $table->addRow(400);//行高400+

        $table->addCell(2000)->addText('苹果手机');
        $table->addCell(2000)->addText('5999元');
        $table->addCell(2000)->addText('10');

        //页眉与页脚
//        $header = $section->createHeader();
//        $footer = $section->createFooter();
//        $header->addPreserveText('LanRenKaiFa.com');
//        $footer->addPreserveText('学会偷懒，并懒出效率。 - LanRenKaiFa.com Page {PAGE} of {NUMPAGES}.');

        // 查询文件夹下是否有此文件
        $fileName = 'test';
        $postfix = ".docx";
        $file = dirname(PUBLIC_PATH) . '\\' . $fileName . $postfix;
        if(file_exists($file)){
            $fileName = $fileName . "(1)" . $postfix;
        }
//        echo $fileName;

        //生成的文档为Word2007
        $writer = \PHPWord_IOFactory::createWriter($phpword, 'Word2007');

        $writer->save($fileName . $postfix);

    }

    public function exportNewWord(Request $request)
    {
        $file_type = $request->get('file_type');
        $plan_id = $request->get('plan_id');
        $content_type = $request->get('content_type');
        $phpWord = new \PHPWord();
        $section = $phpWord->createSection();
        // 简单文本
        $section->addTitle('CA重庆起止-阿联酋7天5晚', 1);
        $section->addText('阿拉伯联合酋长国（The United Arab Emirates），简称为阿联酋，位于阿拉伯半岛东部，北濒波斯湾，西北与卡塔尔为邻，西和南与沙特阿拉伯交界，东和东北与阿曼毗连海岸线长734公里，总面积83600平方公里，首都阿布扎比。!');
        // 两个换行符
        $section->addTextBreak(2);
        $section->addText('第一天：请各位贵宾出发当日15:30于重庆江北国际机场集中，搭乘中国国际航空公司下午航班（CA451（1840/2215））前往迪拜。抵达后迪拜国际机场，照眼角膜后（无须填入境卡）入境（过关时间约1.5小时）中文导游接机，后前往酒店入住休息');

        $section->addTextBreak();
        //超链接
        $section->addLink('http://keketour.me', '可可兔首页超链接');
        $section->addTextBreak();
        // 保存文件
//        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer = \PHPWord_IOFactory::createWriter($phpWord, 'Word2007');

        $writer->save(storage_path().'/word/'.'hello.docx');
    }

    public function exportWord()
    {
        $phpword = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpword->addSection();

        $titleFontStyle = $contentFontStyle = [
            'name' => '宋体',
            'size' => 11,
            'color' => '#000000',
//            'bold' => true
        ];
        // $section->addText($text, [$fontStyle], [$paragraphStyle]);
        $titleFontStyle['bold'] = true;
//        $phpword->addParagraphStyle('paragraphStyle', ['lineHeight' => 1.5]);
//        $lineHeight = ['lineHeight' => 1.5];

        $phpword->addParagraphStyle(
            'paragraphStyle',array(
                'align'=>'both',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'lineHeight' => 3,  // 行间距
            )
        );

        $textContent = $section->addTextRun();
        $textContent->addText('一、爱的小默默（第三周）      班别：      姓名：      学号：      成绩：      <w:br />', $titleFontStyle, 'paragraphStyle');

        //spacingLineRule
//        $textContent->
        $textContent->addText('1.几处早莺争暖树，____________。<w:br />', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('2.____________，风正一帆悬。', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('3.____________，将以遗所思。<w:br />', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('4.月下飞天镜，____________。', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('5.乡书何处达？____________。<w:br />', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('6.____________，路远莫致之。', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('7.夕阳西下，____________。<w:br />', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('8.____________，万里送行舟。', $contentFontStyle, 'paragraphStyle');
        $textContent->addText('8.最爱湖东行不足，____________。', $contentFontStyle, 'paragraphStyle');
        // 查询文件夹下是否有此文件
        $fileName = 'test';
        $postfix = ".docx";
        $file = dirname(PUBLIC_PATH) . '\\' . $fileName . $postfix;
        if(file_exists($file)){
            $fileName = $fileName . "(1)" . $postfix;
        }
        // 把生成的 word 文档放在服务器上，即项目的文件夹中;
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
//        $objWriter->save('hellwoeba.docx');
        $objWriter->save($fileName . $postfix);
        

    }
    
    public function parentsSign()
    {
        return view('user/parents_sign/sign_index');
    }

    // 学生成绩
    public function stuGrade()
    {
//        $classInfo = json_decode(json_encode(DB::table('class_info')->get('class_no')));
        $class_no = '1804';
        $classInfo = DB::table('class_info')->get('class_no');
        $test_describe = DB::table('test_describes')->get('describe');
        $student_grades = DB::table('students')->where('class', $class_no)->get();
        $class_arr = [];
        $describe_arr = [];
        foreach ($classInfo as $value) {
            array_push($class_arr, $value->class_no);
        }
        foreach ($test_describe as $describe) {
            array_push($describe_arr, $describe->describe);
        }
        $student_grades = [];
        return view('user/stu_grade/index', ['class_info' => $class_arr, 'test_describe' => $describe_arr,
            'students_grades' => $student_grades]);
    }

    // 导入学生成绩
    public function uploadExcelStuGrades(Request $request, $options = [])
    {
        set_time_limit(0);
        $class_no = $request->input('class_no');
        $describe = $request->input('describe');
        $excelFile = $request->file('upload_file');
        $level = $request->input('level');
        $objRead = IOFactory::createReader('Xlsx');

        if(!$objRead->canRead($excelFile)){
            $objRead = IOFactory::createReader('Xls');
            if(!$objRead->canRead($excelFile)){
                return "只支持导入.xlsx 和 .xls 格式的 excel 文件";
            }
        }

        $objRead->setReadDataOnly(true);
        $excel = $objRead->load($excelFile);
        $currSheet = $excel->getSheet(0);

        $columnCnt = 0;
        if (0 == $columnCnt) {
            /* 取得最大的列号 */
            $columnH = $currSheet->getHighestColumn();
            /* 兼容原逻辑，循环时使用的是小于等于 */
            $columnCnt = Coordinate::columnIndexFromString($columnH);
        }

        $rowCnt = $currSheet->getHighestRow();
        $data   = [];
        /* 读取内容 */
        for ($_row = 3; $_row <= $rowCnt; $_row++) {
            $isNull = true;

            for ($_column = 1; $_column <= $columnCnt; $_column++) {
                $cellName = Coordinate::stringFromColumnIndex($_column);
                $cellId   = $cellName . $_row;
                $cell     = $currSheet->getCell($cellId);

                if (isset($options['format'])) {
                    /* 获取格式 */
                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
                    /* 记录格式 */
                    $options['format'][$_row][$cellName] = $format;
                }

                if (isset($options['formula'])) {
                    /* 获取公式，公式均为=号开头数据 */
                    $formula = $currSheet->getCell($cellId)->getValue();

                    if (0 === strpos($formula, '=')) {
                        $options['formula'][$cellName . $_row] = $formula;
                    }
                }

                if (isset($format) && 'm/d/yyyy' == $format) {
                    /* 日期格式翻转处理 */
                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
                }

                $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());

                if (!empty($data[$_row][$cellName])) {
                    $isNull = false;
                }
            }

            /* 判断是否整行数据为空，是的话删除该行数据 */
            if ($isNull) {
                unset($data[$_row]);
            }
        }

        // 2、将每个班的成绩，依次录入数据库;
        for ($i = 3;$i <= count($data); $i++){
            $gradesData = [
                'class' => $class_no,
                'exam_no' => $data[$i]['B'],
                'stu_name' => $data[$i]['C'],
                'chinese' => $data[$i]['D'],
                'math' => $data[$i]['E'],
                'english' => $data[$i]['F'],
                'political' => $data[$i]['G'],              // 政治
                'history' => $data[$i]['H'],
                'describe' => $describe,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'total_points' => $data[$i]['I'],
                'class_ranking' => $data[$i]['K'],
                'grade_ranking' => $data[$i]['J'],
            ];
            if($level == 2){
                $gradesData['geography'] = $data[$i]['L'];
                $gradesData['biology'] = $data[$i]['M'];
                $gradesData['chemical'] = $data[$i]['N'];
                $gradesData['physical'] = 0;
            }else if($level == 3){
                $gradesData['chemical'] = $data[$i]['L'];
                $gradesData['physical'] = $data[$i]['M'];
                $gradesData['geography'] = 0;
                $gradesData['biology'] = 0;
            }else{
                $gradesData['geography'] = $data[$i]['L'];
                $gradesData['biology'] = $data[$i]['M'];
                $gradesData['chemical'] = 0;
                $gradesData['physical'] = 0;
            }
            $gradesData['level'] = $level;
            DB::table('students')->insertGetId($gradesData);
        }
        return redirect(url("user/stu_grade"));
    }

    public function getTenStudents(Request $request)
    {
        $value = $request->except('_token');
        $ten_students = DB::table('students')->where('class', $value['class_no'])
            ->orderBy($value['subject'], 'desc')->limit(10)->select('stu_name', $value['subject'])->get();
        return $ten_students;
    }

    public function getStudentGrades(Request $request)
    {
        $value = $request->except('_token');
        $show_grades = DB::table('students')->where('class', $value['class_no'])
            ->where('describe', $value['test_describe'])->orderBy('grade_ranking')->get();
        return $show_grades;
    }

    // 获取学生的所有成绩与排名
    public function getStudentAllGrades(Request $request)
    {
        // 学生姓名，考试描述，各科成绩，总分，排名
        $classInfo = DB::table('class_info')->get('class_no');
        $test_describe = DB::table('test_describes')->get('describe');
        $class_arr = [];
        $describe_arr = [];
        foreach ($classInfo as $value) {
            array_push($class_arr, $value->class_no);
        }
        foreach ($test_describe as $describe) {
            array_push($describe_arr, $describe->describe);
        }

        return view('user/stu_grade/get_student_all_grades',
            ['test_describe' => $describe_arr, 'class_info' => $class_arr]);

    }

    public function showStudentAllGrades(Request $request)
    {
        $select = ['stu_name', 'level', 'describe', 'class_ranking', 'grade_ranking', 'chinese', 'math', 'english',
            'political', 'chemical', 'history', 'geography', 'biology', 'physical', 'total_points'];
        $class_no = $request->input('class_no');
        $student = DB::table('students')->where('class', $class_no)->orderBy('created_at', 'desc')
            ->select($select)->get()->groupBy('stu_name');
        $student = json_decode(json_encode($student, JSON_UNESCAPED_UNICODE), true);
        return $student;
    }


    // 德智体美表，要先将其他信息，录入数据库，再把数据库里成绩表和德智体美表里的数据，全都导入到excel文件即可
    public function showDZTM(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //设置sheet的名字  两种方法
        $spreadsheet->getActiveSheet()->setTitle('Hello');
        //设置第一行小标题
        $k = 1;
        $sheet->setCellValue('A'.$k, '商品名称');
        $sheet->setCellValue('B'.$k, '价格');
        $sheet->setCellValue('C'.$k, '分类');
        $sheet->setCellValue('D'.$k, '描述');
        $info = array(
            ['goods_name'=>'内衣','price'=>'11','category'=>'性感内衣','desc'=>'1111'],
            ['goods_name'=>'裙子','price'=>'80','category'=>'齐B短裙','desc'=>'1111'],
            ['goods_name'=>'裤子','price'=>'60','category'=>'七分裤','desc'=>'1111'],
            ['goods_name'=>'袜子','price'=>'70','category'=>'连体丝袜','desc'=>'1111']
        );
        $k = 2;
        foreach ($info as $key => $value) {
            $sheet->setCellValue('A' . $k, $value['goods_name']);
            $sheet->setCellValue('B' . $k, $value['price']);
            $sheet->setCellValue('C' . $k, $value['category']);
            $sheet->setCellValue('D' . $k, $value['desc']);
            $k++;
        }
        $file_name = date('Y-m-d', time()).rand(1000, 9999);
        $file_name = $file_name . ".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }



    // 获取进步前十的学生
    public function getProgressTen(Request $request)
    {
        // 展示三个下拉框，选择两次考试以及班级

        $class_info = $this->obj2arr(DB::table('class_info')->get());
        $test_describe = $this->obj2arr(DB::table('test_describes')->orderBy('created_at', 'desc')->get());
//        var_dump($test_describe);
//        exit;
        return view('user/stu_grade/progress_student_index', ['class_info' => $class_info, 'test_describe' => $test_describe]);
    }

    public function showProgressTen(Request $request)
    {
        $class_no = '1804';
        $first_describe = '八上12月月考';
        $last_describe = '八年级上学期期末考试';
        $select = ['stu_name', 'grade_ranking'];
        $ranking = [];
        // 获取 first_describe 的排名以及 last_describe 的排名，以及学生姓名，然后放到数组中相减，再放到一个数组中，再排序即可
        $first_ranking = $this->obj2arr(DB::table('students')->where('class', $class_no)
            ->where('describe', $first_describe)->select($select)->get());
        $last_ranking = $this->obj2arr(DB::table('students')->where('class', $class_no)
            ->where('describe', $last_describe)->select($select)->get());
        $i = 0;
        foreach ($first_ranking as $first_key => $first_value){
            foreach ($last_ranking as $last_key => $last_value){
                if($first_value['stu_name'] == $last_value['stu_name']){
                    $change = $last_value['grade_ranking'] - $first_value['grade_ranking'];
                    $data = ['stu_name' => $first_value['stu_name'], 'change' => $change,
                        'first_ranking' => $first_value['grade_ranking'], 'last_ranking' => $last_value['grade_ranking']];
                    array_push($ranking, $data);
                }
            }
        }

        array_multisort(array_column($ranking, 'change'), SORT_DESC, $ranking);
        $ranking = array_slice($ranking, 0, 10);
        return $ranking;
    }


    // 德智体美表的导出方案步骤：
    // 1.将除了成绩以外的德智体美表的数据导入数据库
    // 2.如未导入成绩，先将成绩导入进去，再在导出德智体美表页面导出德智体美表
    // 即将两个数据库的表的信息，都放入一个 excel 表格中即可

    public function dztmIndex(Request $request)
    {
        $classInfo = DB::table('class_info')->get('class_no');
        $test_describe = DB::table('test_describes')->get('describe');
        $class_arr = [];
        $describe_arr = [];
        foreach ($classInfo as $value) {
            array_push($class_arr, $value->class_no);
        }
        foreach ($test_describe as $describe) {
            array_push($describe_arr, $describe->describe);
        }
        $student_grades = [];
        return view('user/stu_grade/dztm_index', ['class_info' => $class_arr, 'test_describe' => $describe_arr,
            'students_grades' => $student_grades]);
    }

    public function exploadDZTM(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //设置sheet的名字  两种方法
        $spreadsheet->getActiveSheet()->setTitle('德智体美表');
        // 获取到填入的表格的信息
        set_time_limit(0);
        $class_no = $request->input('class_no');
        $describe = $request->input('describe');
        $excelFile = $request->file('upload_file');
        $level = $request->input('level');
        $objRead = IOFactory::createReader('Xlsx');

        if(!$objRead->canRead($excelFile)){
            $objRead = IOFactory::createReader('Xls');
            if(!$objRead->canRead($excelFile)){
                return "只支持导入.xlsx 和 .xls 格式的 excel 文件";
            }
        }

        $objRead->setReadDataOnly(true);
        $excel = $objRead->load($excelFile);
        $currSheet = $excel->getSheet(0);

        $columnCnt = 0;
        if (0 == $columnCnt) {
            /* 取得最大的列号 */
            $columnH = $currSheet->getHighestColumn();
            /* 兼容原逻辑，循环时使用的是小于等于 */
            $columnCnt = Coordinate::columnIndexFromString($columnH);
        }

        $rowCnt = $currSheet->getHighestRow();
//        $headData = [];
        $data   = [];
        $rowCntNum = $rowCnt - 2;
        /* 读取内容 */
        // 读取首部公共部分
//        for ($_row = 1; $_row <= 2; $_row++) {
//            $isNull = true;
//            for ($_column = 1; $_column <= $columnCnt; $_column++) {
//                $cellName = Coordinate::stringFromColumnIndex($_column);
//                $cellId   = $cellName . $_row;
//                $cell     = $currSheet->getCell($cellId);
//
//                if (isset($options['format'])) {
//                    /* 获取格式 */
//                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
//                    /* 记录格式 */
//                    $options['format'][$_row][$cellName] = $format;
//                }
//
//                if (isset($options['formula'])) {
//                    /* 获取公式，公式均为=号开头数据 */
//                    $formula = $currSheet->getCell($cellId)->getValue();
//
//                    if (0 === strpos($formula, '=')) {
//                        $options['formula'][$cellName . $_row] = $formula;
//                    }
//                }
//
//                if (isset($format) && 'm/d/yyyy' == $format) {
//                    /* 日期格式翻转处理 */
//                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
//                }
//
//                $headData[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());
//
//                if (!empty($headData[$_row][$cellName])) {
//                    $isNull = false;
//                }
//            }
//
//            /* 判断是否整行数据为空，是的话删除该行数据 */
//            if ($isNull) {
//                unset($headData[$_row]);
//            }
//        }
        for ($_row = 1; $_row <= $rowCnt; $_row++) {
            $isNull = true;
            for ($_column = 1; $_column <= $columnCnt; $_column++) {
                $cellName = Coordinate::stringFromColumnIndex($_column);
                $cellId   = $cellName . $_row;
                $cell     = $currSheet->getCell($cellId);

                if (isset($options['format'])) {
                    /* 获取格式 */
                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
                    /* 记录格式 */
                    $options['format'][$_row][$cellName] = $format;
                }

                if (isset($options['formula'])) {
                    /* 获取公式，公式均为=号开头数据 */
                    $formula = $currSheet->getCell($cellId)->getValue();

                    if (0 === strpos($formula, '=')) {
                        $options['formula'][$cellName . $_row] = $formula;
                    }
                }

                if (isset($format) && 'm/d/yyyy' == $format) {
                    /* 日期格式翻转处理 */
                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
                }

                $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());

                if (!empty($data[$_row][$cellName])) {
                    $isNull = false;
                }
            }

            /* 判断是否整行数据为空，是的话删除该行数据 */
            if ($isNull) {
                unset($data[$_row]);
            }
        }

        $zm = 65;
        $select = ['chinese', 'math', 'english', 'political', 'history', 'biology', 'geography', 'chemical', 'physical', 'total_points', 'class_ranking', 'grade_ranking'];
//        for ($i = 3; $i <= $rowCnt; $i++){
//            if($i == 1){
//                $sheet->setCellValue('A'.$i, $data[$i]['A']);
//            }else{
//                $zm_in = strtoupper(chr($zm));
//                if($i == 2){
////                    foreach ($data[$i] as $value) {
////                        $sheet->setCellValue($zm_in . $i, $value);
////                        $zm_in++;
////                    }
////                    $sheet->setCellValue($zm_in.$i, $data[$i]['A']);
//                }else{
//                    // 1.拿到姓名，然后查询数据库，再将查到的数据，替换进去
//                    $student_grades = DB::table('students')->where('stu_name', $data[$i]['C'])
//                    ->where('class', $class_no)->where('describe', $describe)->select($select)->first();
//                    $sheet->setCellValue($zm_in.$i, $data[$i]['A']);
//                    $sheet->setCellValue($zm_in.$i, $data[$i]['B']);
//                    $sheet->setCellValue($zm_in.$i, $data[$i]['C']);
//                    $sheet->setCellValue($zm_in.$i, $student_grades->chinese);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->math);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->english);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->political);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->history);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->total_points);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->grade_ranking);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->class_ranking);
////                    if($level == 1){
////                        $sheet->setCellValue($zm_in.$i, $student_grades->geography);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->biology);
////                    }else if($level == 2){
////                        $sheet->setCellValue($zm_in.$i, $student_grades->geography);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->biology);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->chemical);
////                    }else{
////                        $sheet->setCellValue($zm_in.$i, $student_grades->chemical);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->physical);
////                    }
//                }
//                $zm++;
//            }
//        }

//        for ($i = 3; $i <= $rowCnt; $i++){
//            $zm_in = strtoupper(chr($zm));
//            // 1.拿到姓名，然后查询数据库，再将查到的数据，替换进去
//            $student_grades = DB::table('students')->where('stu_name', $data[$i]['C'])
//                ->where('class', $class_no)->where('describe', $describe)->select($select)->first();
//            if($student_grades != ''){
//                $sheet->setCellValue($zm_in.$i, $data[$i]['A']);
//                $sheet->setCellValue($zm_in.$i, $data[$i]['B']);
//                $sheet->setCellValue($zm_in.$i, $data[$i]['C']);
//                $sheet->setCellValue($zm_in.$i, $student_grades->chinese);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->math);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->english);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->political);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->history);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->total_points);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->grade_ranking);
////                    $sheet->setCellValue($zm_in.$i, $student_grades->class_ranking);
////                    if($level == 1){
////                        $sheet->setCellValue($zm_in.$i, $student_grades->geography);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->biology);
////                    }else if($level == 2){
////                        $sheet->setCellValue($zm_in.$i, $student_grades->geography);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->biology);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->chemical);
////                    }else{
////                        $sheet->setCellValue($zm_in.$i, $student_grades->chemical);
////                        $sheet->setCellValue($zm_in.$i, $student_grades->physical);
////                    }
//            }
////
//            $zm++;
////            var_dump($student_grades);
//        }


        $file_name = date('Y-m-d', time()).rand(1000, 9999);
        $file_name = $file_name . ".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }


    public function exploadDZTMX(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //设置sheet的名字  两种方法
        $spreadsheet->getActiveSheet()->setTitle('Hello');
        //设置第一行小标题
        $k = 1;
        $sheet->setCellValue('A'.$k, '商品名称');
        $sheet->setCellValue('B'.$k, '价格');
        $sheet->setCellValue('C'.$k, '分类');
        $sheet->setCellValue('D'.$k, '描述');
        $info = array(
            ['goods_name'=>'内衣','price'=>'11','category'=>'性感内衣','desc'=>'1111'],
            ['goods_name'=>'裙子','price'=>'80','category'=>'齐B短裙','desc'=>'1111'],
            ['goods_name'=>'裤子','price'=>'60','category'=>'七分裤','desc'=>'1111'],
            ['goods_name'=>'袜子','price'=>'70','category'=>'连体丝袜','desc'=>'1111']
        );
        $k = 2;
        foreach ($info as $key => $value) {
            $sheet->setCellValue('A' . $k, $value['goods_name']);
            $sheet->setCellValue('B' . $k, $value['price']);
            $sheet->setCellValue('C' . $k, $value['category']);
            $sheet->setCellValue('D' . $k, $value['desc']);
            $k++;
        }
        $file_name = date('Y-m-d', time()).rand(1000, 9999);
        $file_name = $file_name . ".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function downloadDZTM(Request $request)
    {
        $class_no = $request->input('class_no');
        $describe = $request->input('describe');
        $file = $excelFile = $request->file('upload_file');
        $level = $request->input('level');
        if($excelFile){
            $realPath = $file;
//			$path = $file -> move(app_path().'/storage/uploads');
            $realPath = $file->getRealPath();
            $entension =  $file -> getClientOriginalExtension(); //上传文件的后缀.
//			$tabl_name = date('YmdHis').mt_rand(100,999);
            $tabl_name = '111112';
            $newName = $tabl_name.'.'.'Xlsx';//$entension;
            $path = $file->move(base_path().'/uploads',$newName);
            $cretae_path = base_path().'/uploads/'.$newName;

        }
//        $objRead = IOFactory::createReader('Xlsx');
//        if(!$objRead->canRead($excelFile)){
//            $objRead = IOFactory::createReader('Xls');
//            if(!$objRead->canRead($excelFile)){
//                return "只支持导入.xlsx 和 .xls 格式的 excel 文件";
//            }
//        }
//
//        $objRead->setReadDataOnly(true);
//        $excel = $objRead->load($excelFile);
//        $currSheet = $excel->getSheet(0);
//
//        $columnCnt = 0;
//        if (0 == $columnCnt) {
//            /* 取得最大的列号 */
//            $columnH = $currSheet->getHighestColumn();
//            /* 兼容原逻辑，循环时使用的是小于等于 */
//            $columnCnt = Coordinate::columnIndexFromString($columnH);
//        }
//
//        $rowCnt = $currSheet->getHighestRow();
////        $headData = [];
//        $data   = [];
//        $rowCntNum = $rowCnt - 2;
//        /* 读取内容 */
//        // 读取首部公共部分
////        for ($_row = 1; $_row <= 2; $_row++) {
////            $isNull = true;
////            for ($_column = 1; $_column <= $columnCnt; $_column++) {
////                $cellName = Coordinate::stringFromColumnIndex($_column);
////                $cellId   = $cellName . $_row;
////                $cell     = $currSheet->getCell($cellId);
////
////                if (isset($options['format'])) {
////                    /* 获取格式 */
////                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
////                    /* 记录格式 */
////                    $options['format'][$_row][$cellName] = $format;
////                }
////
////                if (isset($options['formula'])) {
////                    /* 获取公式，公式均为=号开头数据 */
////                    $formula = $currSheet->getCell($cellId)->getValue();
////
////                    if (0 === strpos($formula, '=')) {
////                        $options['formula'][$cellName . $_row] = $formula;
////                    }
////                }
////
////                if (isset($format) && 'm/d/yyyy' == $format) {
////                    /* 日期格式翻转处理 */
////                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
////                }
////
////                $headData[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());
////
////                if (!empty($headData[$_row][$cellName])) {
////                    $isNull = false;
////                }
////            }
////
////            /* 判断是否整行数据为空，是的话删除该行数据 */
////            if ($isNull) {
////                unset($headData[$_row]);
////            }
////        }
//        for ($_row = 1; $_row <= $rowCnt; $_row++) {
//            $isNull = true;
//            for ($_column = 1; $_column <= $columnCnt; $_column++) {
//                $cellName = Coordinate::stringFromColumnIndex($_column);
//                $cellId   = $cellName . $_row;
//                $cell     = $currSheet->getCell($cellId);
//
//                if (isset($options['format'])) {
//                    /* 获取格式 */
//                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
//                    /* 记录格式 */
//                    $options['format'][$_row][$cellName] = $format;
//                }
//
//                if (isset($options['formula'])) {
//                    /* 获取公式，公式均为=号开头数据 */
//                    $formula = $currSheet->getCell($cellId)->getValue();
//
//                    if (0 === strpos($formula, '=')) {
//                        $options['formula'][$cellName . $_row] = $formula;
//                    }
//                }
//
//                if (isset($format) && 'm/d/yyyy' == $format) {
//                    /* 日期格式翻转处理 */
//                    $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
//                }
//
//                $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());
//
//                if (!empty($data[$_row][$cellName])) {
//                    $isNull = false;
//                }
//            }
//
//            /* 判断是否整行数据为空，是的话删除该行数据 */
//            if ($isNull) {
//                unset($data[$_row]);
//            }
//        }
//
//        var_dump($data);


    }


}
