const mail = require('nodemailer');

const trans = mail.createTransport({
    service: 'gmail',
    auth:{
        user: 'kittipobt30@gmail.com',
        pass: '0801049058As'
    }
});

const mailOption = {
    from: 'kittipobt30@gmail.com',
    to: 'oens_4@hotmail.com',
    subject: 'TEST Send mail from node.js',
    text: 'This is how i can test send email from node.js, นี่คือการทดลองการส่งอีเมลจาก node.js'
};

const trans.sendMail(mailOption,function(error, info){
    if(error) throw error;
    console.log('Email send' + info.response);
})