var nodemailer = require('nodemailer');
var serviceResult = require('../model/serviceResult');

const SendEmail = function (req, res){
    try {
            var data = req.query;
            var email = data.email;
            var pass = data.pass;
            var sendto = data.sendto;
            var subject = data.subject;
            var content = data.content;
            var htm;
            var title;
            
            if(data){
                var transporter = nodemailer.createTransport({
                service: 'Gmail',
                secure: true,
                auth: {
                    user: email,
                    pass: pass
                }
            });

            if(content == "business_reg"){
                title = 'ยินดีต้อนรับเข้าสู่บริการจัดหางานมหาวิทยาราชภัฎลัยนครสวรรค์';
                htm = '<table width="100%" border="0">  <tbody>    <tr>      <td align="center"><img src="http://vindictusth.in.th/image/logo.png" width="524" height="167" alt=""/></td>    </tr>    <tr>      <td align="center"><strong>ยินดีต้อนรับบริษัท&nbsp;เข้าสู่ระบบจัดหางานของมหาวิทยาลัยนครสวรรค์</strong></td>    </tr>    <tr>      <td align="center"><table width="500">        <tbody>          <tr>            <td><font color="red">ข้อตกลงการใช้บริการ</font></td>          </tr>          <tr>            <td>- ระบบจัดหางานนี้ในการสัมภาษณ์งาน&nbsp;ทางมหาวิทยาลัยเราจะไม่เข้าไปยุ่งเกี่ยว</td>          </tr>          <tr>            <td>- ท่านจะต้องรับผิดชอบทุกกรณีในกรณีที่เกิดความเสียหายแก่นักศึกษาทุกกรณี</td>          </tr>          <tr>            <td>- การให้บริการนี้ไม่มีค่าใช้จ่ายใด ๆ ทั้งสิ้น</td>          </tr>        </tbody>      </table><br>        <table width="500">          <tbody>            <tr>              <td align="center"><a href="http://vindictusth.in.th/business/confirm.php?email='+ sendto +'" target="_blank">&lt;&lt; คลิ๊กที่นี่เพื่อยืนยันตัวตน &gt;&gt;</a></td>            </tr>          </tbody>        </table>      <p style="font-size: 11px;">ระบบการตัดสินใจการจับคู่และคัดกรอง ตำแหน่งงานของผู้หางานในจังหวัดนครสวรรค์<br>นางสาวอมรพรรณ พวงทอง, นางสาวประกายแก้ว คำมาก<br>มหาวิทยาลัยราชภัฏนครสวรรค์ คณะวิทยาการจัดการ สาขาคอมพิวเตอร์ธุรกิจ</p></td>    </tr>  </tbody></table>';
            } else if(content == "student_reg"){
                title = 'ยินดีต้อนรับนักศึกษาเข้าสู่บริการจัดหางานมหาวิทยาราชภัฎลัยนครสวรรค์';
                htm = '<table width="100%" border="0">  <tbody>    <tr>      <td align="center"><img src="http://vindictusth.in.th/image/logo.png" width="524" height="167" alt=""/></td>    </tr>    <tr>      <td align="center"><strong>ยินดีต้อนรับนักศึกษา&nbsp;เข้าสู่ระบบจัดหางานของมหาวิทยาลัยนครสวรรค์</strong></td>    </tr>    <tr>      <td align="center"><table width="500">        <tbody>          <tr>            <td><font color="red">ข้อตกลงการใช้บริการ</font></td>          </tr>          <tr>            <td>- ระบบจัดหางานนี้ในการสัมภาษณ์งาน&nbsp;ทางมหาวิทยาลัยเราจะไม่เข้าไปยุ่งเกี่ยว</td>          </tr>          <tr>            <td>- นักศึกษาจะต้องจัดเตรียม Portfolio หรือ Resume เอง</td>          </tr>          <tr>            <td>- การได้งานหรือไม่ได้งานนั้นขึ้นอยู่กับผู้จ้างงานนั้น ๆ ไม่เกี่ยวกับทางมหาวิทยาลัย</td>          </tr>          <tr>            <td>- ไม่มีการเก็บเงินค่าบริการใด ๆ ทั้งสิ้น</td>          </tr>        </tbody>      </table><br>        <table width="500">          <tbody>            <tr>              <td align="center"><a href="http://vindictusth.in.th/student/confirm.php?email='+ sendto +'">&lt;&lt; คลิ๊กที่นี่เพื่อยืนยันตัวตน &gt;&gt;</a></td>            </tr>          </tbody>        </table>      <p style="font-size: 11px;">ระบบการตัดสินใจการจับคู่และคัดกรอง ตำแหน่งงานของผู้หางานในจังหวัดนครสวรรค์<br>นางสาวอมรพรรณ พวงทอง, นางสาวประกายแก้ว คำมาก<br>มหาวิทยาลัยราชภัฏนครสวรรค์ คณะวิทยาการจัดการ สาขาคอมพิวเตอร์ธุรกิจ</p></td>    </tr>  </tbody></table>';
            }
            
            var mailOptions = {
                from: email,
                to: sendto,
                subject: title,
                html: htm
            };
            
            transporter.sendMail(mailOptions, function(err, info){
                if (err) {
                    console.log(err);
                    serviceResult.code = 500;
                    serviceResult.status = "Error";
                    serviceResult.text = "Error: " + err.message;
                    res.json(serviceResult);
                } else {
                    console.log('Email sent: ' + info.response);
                    serviceResult.code = 200;
                    serviceResult.status = "Success";
                    res.json(serviceResult);
                }
            });
        } else {
            console.log(err);
            log.error(err.stack);
            serviceResult.code = 500;
            serviceResult.status = "Error";
            serviceResult.text = "Error: " + err.message;
            res.json(serviceResult);
        }
    } catch (err) {
        console.log(err);
        log.error(err.stack);
        serviceResult.code = 500;
        serviceResult.status = "Error";
        serviceResult.text = "Error: " + err.message;
        res.json(serviceResult);
    }
}
module.exports = { SendEmail }