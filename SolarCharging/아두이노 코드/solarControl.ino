int mode = 0;
int prevPort = 0;
int cnt1 = 0;
int cnt2 = 0;
boolean change5VSignal = false;
boolean checkState = false;
boolean rechange5VSignal = false;

const int solar = A0;
const int general = A1;
const int port1 = A2;
const int port2 = A3;
const int panel = A4; // panel to controller
const int ctrller = A5; // Solar controller to battery

const int RelayControl = 3;//5v 릴레이

boolean portState1 = false;
boolean portState2 = false;
boolean portState3 = false;

// default는 일반전력모드
boolean SolarMode = false;
boolean GeneralMode = true;
boolean solarSensor = false;
boolean generalSensor = true;
boolean panelSensor = false;
boolean ctrllerSensor = false;

boolean batteryFull = false; //panel to controller, 배터리 80 signal

//전류측정
float panelAmp = 0.0;
float batteryAmp = 0.0;
float solarAmp = 0.0;
float generalAmp = 0.0;
float port1Amp = 0.0;
float port2Amp = 0.0;


void setup() {
  pinMode(RelayControl, OUTPUT);
  Serial.begin(9600);
}

void loop() {

  checkPrevPortState(); // 이전 포트값 확
  
  estimateAmp(solar, solarAmp, solarSensor);      // 태양광 전력
  estimateAmp(general, generalAmp, generalSensor);// 일반 전력
  estimateAmp(panel, panelAmp, panelSensor);      // 패널 -> 배터리
  estimateAmp(ctrller, batteryAmp, ctrllerSensor);// 컨트롤러 -> 배터리
  estimateAmp(port1, port1Amp, portState1);       // 1번 port
  estimateAmp(port2, port2Amp, portState2);       // 2번 port

  // 3번 port 전류
  estimatePort3();

  checkCnt1();// 1차 cnt 체크
  checkCnt2();// 2차 cnt 체크

  checkBatteryFull();//배터리 완충 확인
  changeRelay();//릴레이 변경

  delay(2000);
}

// 전류값 측정 함수
void estimateAmp(float analogN, float Amp, boolean sensor) {
  float temp = analogRead(analogN);
  Amp = (((temp - 511) * 5 / 0.185) / 1024);
  if (Amp < 0) {
    Amp = 0;
  }
  else if (Amp > 0.4) {
    sensor = true;
  } else {
    sensor = false;
  }
}
void estimatePort3(){
  if (mode == 0) {
    if (generalAmp >= 3.5 && portState1 + portState2 == 2) {
      portState3 = true;
    }
    else if (generalAmp >= 2.3 && portState1 + portState2 == 1) {
      portState3 = true;
    }
    else if (generalAmp >= 1.0 && portState1 + portState2 == 0) {
      portState3 = true;
    }
    else {
      portState3 = false;
    }
  }
}




void checkBatteryFull(){
  if (panelSensor == true && ctrllerSensor == false) {
    batteryFull = true;
  }
  else {
    batteryFull = false;
  }
}

//전력원 제어 함수
void ChangeToSolarMode() {
  digitalWrite(RelayControl, HIGH);//태양광 사용
  SolarMode = true;
  GeneralMode = false;
  mode = 1;//Solar
}
void ChangeToGeneralMode() {
  digitalWrite(RelayControl, LOW);//일반 사용
  SolarMode = false;
  GeneralMode = true;
  mode = 0;//General
}
void ChangeToBlackoutMode() {
  digitalWrite(RelayControl, HIGH);//태양광 사용
  SolarMode = true;
  GeneralMode = false;
  mode = 2;//Solar
}
void changeRelay(){
  if (change5VSignal == true) {//전력측정량이 전부 0이 될 경우 (포트연결 없음 or 방전 or 정전)
    cnt1 = 0;
    change5VSignal = false; //1차 cnt체크 완료, reset
    checkState = true; //2차 cnt 체크 시작

    if (GeneralMode == true && SolarMode == false) { // (포트연결 없음 or 정전) 일반모드 > 태양광
      ChangeToSolarMode();
    }
    else if (GeneralMode == false && SolarMode == true) { // (포트연결 없음 or 방전) 태양광모드 > 일반
      ChangeToGeneralMode();
    }
    else if (GeneralMode == true && SolarMode == true) { // (포트연결 없음 or 방전) 정전모드(태양광사용) > 일반
      ChangeToBlackoutMode();
    }
  }
  else if (rechange5VSignal == true) {// 포트연결 없음으로 인식, 다시 모드 원상복구
    cnt2 = 0;
    rechange5VSignal = false; //2차 cnt체크 완료, reset
    checkState = false;

    if (GeneralMode == true && SolarMode == false) { // 일반모드 > 태양광
      ChangeToSolarMode();
    }
    else if (GeneralMode == false && SolarMode == true) { // 태양광모드 > 일반
      ChangeToGeneralMode();
    }
  }
  else {//그 외 배터리 풀충상태
    if (batteryFull == true && GeneralMode == true) {//일반 > 태양
      ChangeToSolarMode();
    }
  }
}
void checkPrevPortState(){
  if (portState1 + portState2 + portState3 > 0) { // 이전 포트값 확
    prevPort = 1;
  } else {
    prevPort = 0;
  }
}
void checkCnt1() {
  if (cnt1 == 0 && prevPort == 1 && portState1 + portState2 + portState3 == 0) {
    cnt1++;
  }
  else if (cnt1 > 0 && cnt1 < 5 && prevPort == 0 && portState1 + portState2 + portState3 == 0) {
    cnt1++;
  }
  else {
    cnt1 = 0; // 잠시 노이즈 or 오류로 인한 이상데이터로 인식해 cnt체크 끝내고 리셋
  }
  if (cnt1 == 5) {
    change5VSignal = true;
  }
}
void checkCnt2() {
  if (checkState == true) {
    if (cnt2 < 5 && prevPort == 0 && portState1 + portState2 + portState3 == 0) {
      cnt2++;
    }
    else {
      resetAllCnt();
    }
    if (cnt2 == 5) {
      rechange5VSignal = true; // 포트 제거상태로 인식, 모드 원상복구
    }
  }
}
void resetAllCnt() {
  cnt1 = 0;
  cnt2 = 0;
  change5VSignal = false; //1차 cnt체크 완료, reset
  rechange5VSignal = false; //2차 cnt체크 완료, reset
  checkState = false;
}
