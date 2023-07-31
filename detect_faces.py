import cv2

def detect_faces(input_path, output_path):
    image = cv2.imread(input_path)
    
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
    
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    
    faces = face_cascade.detectMultiScale(gray_image, scaleFactor=1.1, minNeighbors=5)
    
    for (x, y, w, h) in faces:
        cv2.rectangle(image, (x, y), (x + w, y + h), (255, 0, 0), 2)
    
    cv2.imwrite(output_path, image)

if __name__ == "__main__":
    input_image_path = "path_to_input_image.jpg"
    output_image_path = "path_to_output_image_with_faces.jpg"
    
    detect_faces(input_image_path, output_image_path)
