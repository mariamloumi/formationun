package rect;

public class Main {
    
    public static void main(String[] args) {
        Rectangle s = new Rectangle();
        s.setWidth(10);
        s.setHeight(2);
        double w =  s.getWidth();
        double h = s.getHeight();
        System.out.println("Width " + w + " Height " + h);
    }
}
