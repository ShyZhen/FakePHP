<?php
/**
 * 示例控制器（默认控制器）
 *
 * @Author huaixiu.zhen
 * http://litblc.com
 * User: z00455118
 * Date: 2018/8/30
 * Time: 15:50
 */

namespace App\Controllers;

use QL\QueryList;
use QL\Ext\PhantomJs;

class Index extends Controller
{
    /**
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        // ?controller=index&action=index
        $data = ['data' => 'welcome to fakePHP'];
        echo $this->view->render('welcome.html', $data);
    }

    public function spader()
    {
        $this->handleSpader(521);
    }

    public function handleSpader($id)
    {
        $url = 'https://pvp.qq.com/web201605/herodetail/'.$id.'.shtml';
        $ql = QueryList::getInstance();
        $ql->use(PhantomJs::class,'E:/githubShyzhen/FakePHP/phantomjs-2.1.1-windows/bin/phantomjs.exe');
        $html = $ql->browser($url)->getHtml();

        $dom = QueryList::html($html);

        $mingTips = $dom->find('.sugg-tips')->text();
        $equipTips = $dom->find('.equip-tips')->eq(0)->text();


        // ming JSON
        $ming1Ids = $dom->find('.sugg-u1')->attr('data-ming');
        $tempIds = explode('|', $ming1Ids);
        $ming1Id = $tempIds[0];
        $ming2Id = $tempIds[1];
        $ming3Id = $tempIds[2];

        $ming1 = $dom->find('.sugg-u1 li')->eq(0);
        $ming2 = $dom->find('.sugg-u1 li')->eq(1);
        $ming3 = $dom->find('.sugg-u1 li')->eq(2);


        $ming1Name = $ming1->find('p')->eq(0)->text();
        $ming1Intro1 = $ming1->find('p')->eq(1)->text();
        $ming1Intro2 = $ming1->find('p')->eq(2)->text();
        $ming1Intro3 = $ming1->find('p')->eq(3)->text();


        $ming2Name = $ming2->find('p')->eq(0)->text();
        $ming2Intro1 = $ming2->find('p')->eq(1)->text();
        $ming2Intro2 = $ming2->find('p')->eq(2)->text();
        $ming2Intro3 = $ming2->find('p')->eq(3)->text();

        $ming3Name = $ming3->find('p')->eq(0)->text();
        $ming3Intro1 = $ming3->find('p')->eq(1)->text();
        $ming3Intro2 = $ming3->find('p')->eq(2)->text();
        $ming3Intro3 = $ming3->find('p')->eq(3)->text();

        $mingRes = [
            ['id' => $ming1Id, 'name' => $ming1Name, 'intro' => trim(implode('|', [$ming1Intro1, $ming1Intro2, $ming1Intro3]), '|')],
            ['id' => $ming2Id, 'name' => $ming2Name, 'intro' => trim(implode('|', [$ming2Intro1, $ming2Intro2, $ming2Intro3]), '|')],
            ['id' => $ming3Id, 'name' => $ming3Name, 'intro' => trim(implode('|', [$ming3Intro1, $ming3Intro2, $ming3Intro3]), '|')],
        ];
        $mingJson = json_encode($mingRes, JSON_UNESCAPED_UNICODE);


        // equipment JSON
        $equipmentDom = $dom->find('.equip-list')->eq(0);
        $eIdStr = $equipmentDom->attr('data-item');
        $eIds = explode('|', $eIdStr);
        $e1Id = $eIds[0];
        $e2Id = $eIds[1];
        $e3Id = $eIds[2];
        $e4Id = $eIds[3];
        $e5Id = $eIds[4];
        $e6Id = $eIds[5];

        $e1Name = $equipmentDom->find('#Jname')->eq(0)->text();
        $e2Name = $equipmentDom->find('#Jname')->eq(1)->text();
        $e3Name = $equipmentDom->find('#Jname')->eq(2)->text();
        $e4Name = $equipmentDom->find('#Jname')->eq(3)->text();
        $e5Name = $equipmentDom->find('#Jname')->eq(4)->text();
        $e6Name = $equipmentDom->find('#Jname')->eq(5)->text();

        $eRes = [
            ['id' => $e1Id, 'name' => $e1Name, 'intro' => ''],
            ['id' => $e2Id, 'name' => $e2Name, 'intro' => ''],
            ['id' => $e3Id, 'name' => $e3Name, 'intro' => ''],
            ['id' => $e4Id, 'name' => $e4Name, 'intro' => ''],
            ['id' => $e5Id, 'name' => $e5Name, 'intro' => ''],
            ['id' => $e6Id, 'name' => $e6Name, 'intro' => ''],
        ];
        $eJson = json_encode($eRes, JSON_UNESCAPED_UNICODE);


        // counterHero JSON
        $heroDom = $dom->find('.hero-info-box')->find('.hero-info')->eq(1);
        $h1Id = $heroDom->find('img')->eq(0)->src;
        $h2Id = $heroDom->find('img')->eq(1)->src;
        $h1Intro = $heroDom->find('.hero-list-desc')->find('p')->eq(0)->text();
        $h2Intro = $heroDom->find('.hero-list-desc')->find('p')->eq(1)->text();

        $id1 = substr($h1Id, strripos($h1Id, '/') + 1, strripos($h1Id, '.') - strripos($h1Id, '/') - 1);
        $id2 = substr($h2Id, strripos($h2Id, '/') + 1, strripos($h2Id, '.') - strripos($h2Id, '/') - 1);
        $heroRes = [
            ['id' => $id1, 'name' => $this->handleHeroName($id1), 'intro' => $h1Intro],
            ['id' => $id2, 'name' => $this->handleHeroName($id2), 'intro' => $h2Intro],
        ];
        $heroJson = json_encode($heroRes, JSON_UNESCAPED_UNICODE);

        $resHeroId = $id;
        $resMing = $mingJson;
        $resMingTips = $mingTips;
        $resEquipment = $eJson;
        $resEtips = $equipTips;
        $resCh = $heroJson;

        // 拼装sql
        $sql = "INSERT INTO `wangzhe_hero_tutorial` (`hero_id`,`ming`,`ming_tips`,`equipment`,`equipment_tips`,`counter_hero`, `created_at`, `updated_at`) VALUES ('$resHeroId', '$resMing', '$resMingTips', '$resEquipment', '$resEtips', '$resCh', '2022-03-29 16:29:53', '2022-03-29 16:29:53');";

        echo $sql;

        exit;
    }

    public function handleHeroName($heroId)
    {
        $json = '{
    "105": "廉颇",
    "106": "小乔",
    "107": "赵云",
    "108": "墨子",
    "109": "妲己",
    "110": "嬴政",
    "111": "孙尚香",
    "112": "鲁班七号",
    "113": "庄周",
    "114": "刘禅",
    "115": "高渐离",
    "116": "阿轲",
    "117": "钟无艳",
    "118": "孙膑",
    "119": "扁鹊",
    "120": "白起",
    "121": "芈月",
    "123": "吕布",
    "124": "周瑜",
    "126": "夏侯惇",
    "127": "甄姬",
    "128": "曹操",
    "129": "典韦",
    "130": "宫本武藏",
    "131": "李白",
    "132": "马可波罗",
    "133": "狄仁杰",
    "134": "达摩",
    "135": "项羽",
    "136": "武则天",
    "139": "老夫子",
    "140": "关羽",
    "141": "貂蝉",
    "142": "安琪拉",
    "144": "程咬金",
    "146": "露娜",
    "148": "姜子牙",
    "149": "刘邦",
    "150": "韩信",
    "152": "王昭君",
    "153": "兰陵王",
    "154": "花木兰",
    "156": "张良",
    "157": "不知火舞",
    "162": "娜可露露",
    "163": "橘右京",
    "166": "亚瑟",
    "167": "孙悟空",
    "168": "牛魔",
    "169": "后羿",
    "170": "刘备",
    "171": "张飞",
    "173": "李元芳",
    "174": "虞姬",
    "175": "钟馗",
    "177": "成吉思汗",
    "178": "杨戬",
    "183": "雅典娜",
    "184": "蔡文姬",
    "186": "太乙真人",
    "180": "哪吒",
    "190": "诸葛亮",
    "192": "黄忠",
    "191": "大乔",
    "187": "东皇太一",
    "182": "干将莫邪",
    "189": "鬼谷子",
    "193": "铠",
    "196": "百里守约",
    "195": "百里玄策",
    "194": "苏烈",
    "198": "梦奇",
    "179": "女娲",
    "501": "明世隐",
    "199": "公孙离",
    "176": "杨玉环",
    "502": "裴擒虎",
    "197": "弈星",
    "503": "狂铁",
    "504": "米莱狄",
    "125": "元歌",
    "510": "孙策",
    "137": "司马懿",
    "509": "盾山",
    "508": "伽罗",
    "312": "沈梦溪",
    "507": "李信",
    "513": "上官婉儿",
    "515": "嫦娥",
    "511": "猪八戒",
    "529": "盘古",
    "505": "瑶",
    "506": "云中君",
    "522": "曜",
    "518": "马超",
    "523": "西施",
    "525": "鲁班大师",
    "524": "蒙犽",
    "531": "镜",
    "527": "蒙恬",
    "533": "阿古朵",
    "536": "夏洛特",
    "528": "澜",
    "537": "司空震",
    "155": "艾琳",
    "538": "云缨",
    "540": "金蝉",
    "542": "暃",
    "534": "桑启",
    "548": "戈娅"
    "521": "海月"
}';
        $heroArr = json_decode($json, true);
        return $heroArr[$heroId];
    }


}
