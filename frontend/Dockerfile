# build stage
# build vue project with node image
FROM node:22 AS build

WORKDIR /app

# first copy only package files (for cache)
COPY package.json package-lock.json ./

# install dependencies
RUN npm install

# copy remaining code
COPY . .

# build vue project for production (dist/ folder is created)
RUN npm run build

# service stage
# serve build output with lightweight web server (nginx)
FROM nginx:alpine

# copy static files from build stage to nginx
COPY --from=build /app/dist /usr/share/nginx/html

# nginx runs on port 80
EXPOSE 80