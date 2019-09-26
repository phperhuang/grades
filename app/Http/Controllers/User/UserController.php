<?php

namespace App\Http\Controllers\User;

use App\ClassInfo;
use App\Subject;
use App\TestDescribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\Common\Autoloader;

//use phpword;

class UserController extends Controller
{

    public function home()
    {
        return view('user/index/index');
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


}
