#FROM daxia/qingscan:ub20
FROM daxia/websafe:latest

# 基础内容更新
ENV DEBIAN_FRONTEND=noninteractive
ADD  script.py /root/
RUN  apt update -y && apt install -y python3


# 定义端口为80
EXPOSE 80
CMD ["python3", "/root/script.py"]
#   docker build -t daxia/websafe:v1.0 .