FROM node:18.16.1

WORKDIR /code/frontend

COPY ./code/frontend /code/frontend

ENV NODE_ENV=${NODE_ENV}

RUN npm install
RUN npm rebuild node-sass
RUN npm run build

ENV HOST 0.0.0.0

CMD ["npm", "run", "serve"]
