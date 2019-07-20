<?php
/**
 * Created by PhpStorm.
 * User: yuliang
 * Date: 2019/6/21
 * Time: 下午12:14
 */

namespace App\Http\Controllers;

use TCPDF;

class TcPdfController
{
    public function getPdf(array $data)
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('wudy测试');
        $pdf->SetTitle('余亮的pdf');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // add a page
        $pdf->AddPage();
        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->setCellHeightRatio(1.3);
        $pdf->SetLineWidth(2);

        $tbl = <<<EOD
         <table cellpadding="0" cellspacing="0">
            <tr>
                <th><img src="/adminResource/img/logo_5100.png" width="140" height="40"></th>
                <th style="font-size: 25px;font-weight: bold">出库单</th>
            </tr>
         </table>
         <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-weight: bold">单据日期：{$data['create_time']}</td>
                <td colspan="1"></td>
                <td style="font-weight: bold;text-align: right;width:377px;">出库单号:20190621748372</td>      
            </tr>
         </table>
         <table cellpadding="2" cellspacing="0" border="1" summary="出库单">
                <tr>
                    <th style="font-size: 18px;width:80px;font-weight: bold;">发货仓</th>
                    <td style="font-size: 16px;width: 100px;">{$data['op_user']}</td>
                    <th style="font-size: 18px;width:120px;font-weight: bold">收货公司</th>
                    <td style="font-size: 16px;width: 150px;">{深圳货啦啦}</td>
                    <th rowspan="2" style="font-size: 18px;width:130px;font-weight: bold;line-height:60px;">提货/收货地址</th>
                    {罗湖区笋岗街道洪湖二街}
                </tr>

                <tr>
                    <th style="font-size: 18px;font-weight: bold">发货人</th>
                    <td style="font-size: 16px;">{$data['杨恩网']}</td>
                    <th style="font-size: 18px;font-weight: bold">发货人电话</th>
                    <td style="font-size: 16px;">{13074491521}</td>
                </tr>

                <tr>
                    <th style="font-size: 18px;font-weight: bold">提货人/收货人信息</th>
                    <td colspan="2" style="font-size: 16px;line-height:60px;">{余亮}</td>
                    <td style="font-size: 16px;line-height:60px;">{18973038382}</td>
                    <th style="font-size: 18px;font-weight: bold;line-height:60px;">要求配送时间</th>
                    <td colspan="2" style="font-size: 16px;line-height:60px;">{$data['modify_time']}</td>
                </tr>

                <tr>
                    <th style="font-size: 18px;font-weight: bold">订单备注</th>
                    <td colspan="6" style="font-size: 16px;">{$data['remark']}</td>
                </tr>

                <tr>
                    <th colspan="7" style="font-size: 18px;text-align: center;font-weight: bold">出库明细</th>
                </tr>

                <tr>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:80px;">编号</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:275px;">货品名称</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:60px;">属性</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:70px;">单位</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:90px;">出货数量</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:90px;">实发数量</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:90px;">实收数量</td>
                    <td style="font-size: 18px;text-align: center;font-weight: bold;width:280px;">备注</td>
                </tr>
               
                <tr>
                    <th style="font-size: 18px;font-weight: bold">签收人</th>
                    <td colspan="3"></td>
                    <th style="font-size: 18px;font-weight: bold">签收日期</th>
                    <td colspan="3"></td>
                </tr>
                <b>请签收人签字后务必将扫描件发至我司联系人邮箱，否则默认实收与实发数量一致</b>
            </table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // -----------------------------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('出库单_'.date('YmdHis').'.pdf', 'I');
    }
}