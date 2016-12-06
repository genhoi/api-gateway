FROM openresty/openresty:latest-xenial

ENV VOLUME_DIR /app
ADD src/ ${VOLUME_DIR}/

RUN mkdir -p ${VOLUME_DIR}/logs

WORKDIR ${VOLUME_DIR}

ENTRYPOINT ["/usr/local/openresty/bin/openresty", "-p", "/app", "-c", "nginx.conf"]
