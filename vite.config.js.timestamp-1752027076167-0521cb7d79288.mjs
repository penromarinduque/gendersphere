// vite.config.js
import { defineConfig } from "file:///C:/xampp/htdocs/gendersphere/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/xampp/htdocs/gendersphere/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/xampp/htdocs/gendersphere/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var vite_config_default = defineConfig({
  // base: 'https://gendersphere.penromarinduque.gov.ph',
  base: "",
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js"
      ],
      refresh: true
      // publicDirectory: "public_html",
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  // build: {
  //     outDir: 'public_html/build',
  // },
  resolve: {
    alias: {
      vue: "vue/dist/vue.esm-bundler.js"
    }
  }
  // server: {
  //     // for production build only remove this for local
  //     // origin: 'localhost:9001',
  //     // origin: 'https://gendersphere.penromarinduque.gov.ph',
  // },
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcZ2VuZGVyc3BoZXJlXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcZ2VuZGVyc3BoZXJlXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi94YW1wcC9odGRvY3MvZ2VuZGVyc3BoZXJlL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICAvLyBiYXNlOiAnaHR0cHM6Ly9nZW5kZXJzcGhlcmUucGVucm9tYXJpbmR1cXVlLmdvdi5waCcsXG4gICAgYmFzZTogJycsXG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHAuanMnLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgICAgICAvLyBwdWJsaWNEaXJlY3Rvcnk6IFwicHVibGljX2h0bWxcIixcbiAgICAgICAgfSksXG4gICAgICAgIHZ1ZSh7IFxuICAgICAgICAgICAgdGVtcGxhdGU6IHtcbiAgICAgICAgICAgICAgICB0cmFuc2Zvcm1Bc3NldFVybHM6IHtcbiAgICAgICAgICAgICAgICAgICAgYmFzZTogbnVsbCxcbiAgICAgICAgICAgICAgICAgICAgaW5jbHVkZUFic29sdXRlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSksXG4gICAgXSxcbiAgICAvLyBidWlsZDoge1xuICAgIC8vICAgICBvdXREaXI6ICdwdWJsaWNfaHRtbC9idWlsZCcsXG4gICAgLy8gfSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICB2dWU6ICd2dWUvZGlzdC92dWUuZXNtLWJ1bmRsZXIuanMnLFxuICAgICAgICB9LFxuICAgIH0sXG4gICAgLy8gc2VydmVyOiB7XG4gICAgLy8gICAgIC8vIGZvciBwcm9kdWN0aW9uIGJ1aWxkIG9ubHkgcmVtb3ZlIHRoaXMgZm9yIGxvY2FsXG4gICAgLy8gICAgIC8vIG9yaWdpbjogJ2xvY2FsaG9zdDo5MDAxJyxcbiAgICAvLyAgICAgLy8gb3JpZ2luOiAnaHR0cHM6Ly9nZW5kZXJzcGhlcmUucGVucm9tYXJpbmR1cXVlLmdvdi5waCcsXG4gICAgLy8gfSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE4USxTQUFTLG9CQUFvQjtBQUMzUyxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBRWhCLElBQU8sc0JBQVEsYUFBYTtBQUFBO0FBQUEsRUFFeEIsTUFBTTtBQUFBLEVBQ04sU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBO0FBQUEsSUFFYixDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixvQkFBb0I7QUFBQSxVQUNoQixNQUFNO0FBQUEsVUFDTixpQkFBaUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxFQUNMO0FBQUE7QUFBQTtBQUFBO0FBQUEsRUFJQSxTQUFTO0FBQUEsSUFDTCxPQUFPO0FBQUEsTUFDSCxLQUFLO0FBQUEsSUFDVDtBQUFBLEVBQ0o7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBTUosQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
